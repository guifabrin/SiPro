<?php

namespace App\Http\Controllers;

use App\Test;
use App\Teste;
use DB;
use Illuminate\Http\Request;

class TestsController extends Controller {

	/**
	 * Variáveis de caminho dos arquivos Blade
	 */
	private $testsViewBlade = "tests.view";
	private $testsCreateEditBlade = "tests.form";
	private $testsConfirmBlade = 'tests.confirm';

	/**
	 * Array de mensagens de retorno das ações executadas no TestsController
	 */
	private $messages = [
		'no_one' => [
			'status' => 'warning',
			'message' => 'Não há nenhum teste cadastrada.',
		],
		'no_user_test' => [
			'status' => 'warning',
			'message' => 'A teste não pertence a você.',
		],
		'test_created' => [
			'status' => 'success',
			'message' => 'Teste criada.',
		],
		'options_no_created' => [
			'status' => 'success',
			'message' => 'Teste criada.',
		],
		'test_no_created' => [
			'status' => 'danger',
			'message' => 'Teste não criado.',
		],
		'test_updated' => [
			'status' => 'success',
			'message' => 'Teste atualizado.',
		],
		'test_no_updated' => [
			'status' => 'danger',
			'message' => 'Teste não atualizado.',
		],
		'test_deleted' => [
			'status' => 'success',
			'message' => 'Teste removido.',
		],
		'test_no_deleted' => [
			'status' => 'danger',
			'message' => 'Teste não removido.',
		],
	];

	/**
	 * Array de titulos do TestsController
	 */
	private $titles = [
		'add' => 'Adicionar',
		'edit' => 'Editar',
	];

	private $testCategoriesController = null;
	private $questionCategoriesController = null;
	private $questionsController = null;
	private $questionsInTestsController = null;

	/**
	 * Construtor
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->testCategoriesController = new TestCategoriesController();
		$this->questionCategoriesController = new QuestionCategoryController();
		$this->questionsController = new QuestionsController();
		$this->questionsInTestsController = new QuestionsInTestsController();
	}

	/**
	 * Função de retorno da visualização de todas as testes;
	 * @return Resonse
	 */
	public function index(Request $request) {
		return $this->index_(null);
	}

	/**
	 * Função de retorno da visualização de testes da categoria selecionada;
	 * @return Response
	 */
	public function index_($id) {
		$message = null;
		$tests = $this->getTests($id);

		$categorie = null;
		$categories = $this->testCategoriesController->getCategories();

		if ($id != null) {
			$categorie = $this->testCategoriesController->getCategorie($id);
		}
		if (count($tests) == 0) {
			$message = $this->messages['no_one'];
		}
		return view($this->testsViewBlade, ['categorie' => $categorie, 'categories' => $categories, 'tests' => $tests, 'message' => $message]);
	}

	/**
	 * Função de retorno de uma teste
	 * @return Test
	 */
	private function getTest($id) {
		$args = ['id' => $id, 'user_id' => \Auth::user()->id, 'soft_delete' => 0];
		return Test::where($args)->first();
	}

	/**
	 * Função de retorno de todas as testes do usuário;
	 * @return Array
	 */
	private function getTests($categorieId) {
		$args;
		if ($categorieId == null) {
			$args = ['user_id' => \Auth::user()->id, 'soft_delete' => 0];
		} else {
			$args = ['user_id' => \Auth::user()->id, 'soft_delete' => 0, 'categorie_id' => $categorieId];
		}
		$tests = Test::where($args)->paginate(15);
		foreach ($tests as $test) {
			$test['categorie'] = $this->testCategoriesController->getCategorie($test->categorie_id);
		}
		return $tests;
	}

	/**
	 * Função que retorna a 'view' de criação da categoria da teste;
	 * @param Request $request;
	 * @return Response;
	 */
	public function create(Request $request) {
		return $this->create_(null);
	}

	/**
	 * Função que retorna a 'view' de criação da categoria da teste;
	 * @param Request $request;
	 * @return Response;
	 */
	public function create_($id) {
		$categorie = null;
		if (isset($id)) {
			$categorie = $this->testCategoriesController->getCategorie($id);
		}

		$categories = $this->testCategoriesController->getCategories();
		return view($this->testsCreateEditBlade, ['title' => $this->titles['add'], 'categorie' => $categorie, 'categories' => $categories]);
	}

	private function endDB($commit, $message, $categorie) {
		if ($commit) {
			DB::commit();
		} else {
			DB::rollBack();
		}
		$tests = $this->getTests(($categorie == null) ? null : $categorie->id);
		$categories = $this->testCategoriesController->getCategories();
		return view($this->testsViewBlade, ['categorie' => ($categorie == null) ? null : $categorie, 'categories' => $categories, 'tests' => $tests, 'message' => $message]);
	}
	/**
	 * Função que armazena uma categoria de teste;
	 * @param Request $request
	 * @return Response;
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'description' => 'required',
		]);

		$input = $request->all();

		if (!isset($input['categorie_id']) || $input['categorie_id'] == "null") {
			$input['categorie_id'] = NULL;
		}

		$input['user_id'] = \Auth::user()->id;

		DB::beginTransaction();
		$categorie = $this->testCategoriesController->getCategorie($input['categorie_id']);

		$input['soft_delete'] = false;
		$test = Test::create($input);

		if ($test) {
			return $this->endDB(true, $this->messages['test_created'], $categorie);
		} else {
			return $this->endDB(false, $this->messages['test_no_created'], $categorie);
		}
	}

	/**
	 * Função que atualiza a teste;
	 * @param $id Identificador da teste;
	 * @param Request $request;
	 * @return Response;
	 */
	public function update(Request $request, $id) {
		$this->validate($request, [
			'description' => 'required',
		]);

		$input = $request->except(['_method', '_token']);

		if (!isset($input['categorie_id']) || $input['categorie_id'] == "null") {
			$input['categorie_id'] = NULL;
		}

		$input['user_id'] = \Auth::user()->id;

		DB::beginTransaction();
		$categorie = $this->testCategoriesController->getCategorie($input['categorie_id']);
		$test = $this->getTest($id);

		$test = Test::where(['id' => $id, 'user_id' => $input['user_id']])->update($input);

		if ($test) {
			return $this->endDB(true, $this->messages['test_updated'], $categorie);
		} else {
			return $this->endDB(false, $this->messages['test_no_updated'], $categorie);
		}
	}

	/**
	 * Função que mostra o formulário para edição da teste;
	 * @param $id Identificador da teste;
	 * @return Response;
	 */
	public function show($id) {
		$message = null;
		$test = $this->getTest($id);
		$categorie = $this->testCategoriesController->getCategorie($test->categorie_id);
		$categories = $this->testCategoriesController->getCategories();
		$questionCategories = $this->questionCategoriesController->getCategories();
		$questions = $this->questionsController->getQuestions(null);
		foreach ($questions as $question) {
			$question['inTest'] = $this->questionsInTestsController->inTest($id, $question->id);
		}
		return view($this->testsCreateEditBlade, ['title' => $this->titles['edit'], 'test' => $test, 'questions' => $questions, 'categorie' => $categorie, 'categories' => $categories, 'questionCategories' => $questionCategories]);
	}

	/**
	 * Função que retorna a 'view' da confirmação para remoção da teste;
	 * @param $id Identificador da teste;
	 * @return Response;
	 */
	public function confirm($id) {
		return view($this->testsConfirmBlade, [
			'test' => $this->getTest($id),
		]);
	}

	/**
	 * Função de remoção da teste através de 'soft delete';
	 * @param $id Identificador da categoria de teste;
	 * @return Response;
	 */
	public function destroy($id) {
		$test = Test::where(['id' => $id, 'user_id' => \Auth::user()->id])->first()->update(['soft_delete' => true]);

		DB::beginTransaction();
		if ($test) {
			return $this->endDB(true, $this->messages['test_deleted'], null);
		} else {
			return $this->endDB(false, $this->messages['test_no_deleted'], null);
		}
	}
}