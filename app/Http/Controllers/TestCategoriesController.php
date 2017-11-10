<?php

namespace App\Http\Controllers;

use App\TestCategorie;
use Illuminate\Http\Request;

class TestCategoriesController extends Controller {
	/**
	 * Variáveis de caminho dos arquivos Blade
	 */
	private $testsCategoriesViewBlade = "tests.categories.view";
	private $testsCategoriesCreateEditBlade = "tests.categories.form";
	private $testsCategoriesConfirmBlade = 'tests.categories.confirm';

	/**
	 * Array de mensagens de retorno das ações executadas no TestCategoriesController
	 */
	private $messages = [
		'no_one' => [
			'status' => 'warning',
			'message' => 'Não há nenhuma categoria de testes cadastrada.',
		],
		'no_user_categorie' => [
			'status' => 'warning',
			'message' => 'A categoria da testes não pertence a você.',
		],
		'categorie_created' => [
			'status' => 'success',
			'message' => 'Categoria de testes criada.',
		],
		'categorie_no_created' => [
			'status' => 'danger',
			'message' => 'Categoria de testes não criada.',
		],
		'categorie_updated' => [
			'status' => 'success',
			'message' => 'Categoria de testes atualizada.',
		],
		'categorie_no_updated' => [
			'status' => 'danger',
			'message' => 'Categoria de testes não atualizada.',
		],
		'categorie_deleted' => [
			'status' => 'success',
			'message' => 'Categoria de testes removida.',
		],
		'categorie_no_deleted' => [
			'status' => 'danger',
			'message' => 'Categoria de testes não removida.',
		],
	];

	/**
	 * Array de titulos do TestCategoriesController
	 */
	private $titles = [
		'add' => 'Adicionar',
		'edit' => 'Editar',
	];

	/**
	 * Construtor
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Função de retorno da visualização de categorias de testes;
	 * @return Response
	 */
	public function index(Request $request) {
		$message = null;
		$categories = $this->getCategories();
		if (count($categories) == 0) {
			$message = $this->messages['no_one'];
		}
		return view($this->testsCategoriesViewBlade, ['categories' => $categories, 'message' => $message]);
	}

	/**
	 * Função de retorno de uma categoria
	 * @return Categorie
	 */
	public function getCategorie($id) {
		$args = ['id' => $id, 'user_id' => \Auth::user()->id, 'soft_delete' => 0];
		return TestCategorie::where($args)->first();
	}

	/**
	 * Função de retorno de todas as categorias do usuário;
	 * @return Array
	 */
	public function getCategories() {
		$args = ['user_id' => \Auth::user()->id, 'soft_delete' => 0];
		return $this->sortRecursiveCategories(null, TestCategorie::where($args)->get());
	}

	/**
	 * Função que retorna a 'view' de criação da categoria da testes;
	 * @param Request $request;
	 * @return Response;
	 */
	public function create(Request $request) {
		$paiId = $request->id;
		$categories = $this->getCategories();

		if (isset($paiId) && $paiId != "") {
			$categorie = $this->getCategorie($paiId);
			if ($categorie) {
				return view($this->testsCategoriesCreateEditBlade, [
					'title' => $this->titles['edit'],
					'fatherCategorie' => $categorie,
					'categories' => $categories,
				]);
			} else {
				return view($this->testsCategoriesCreateEditBlade, [
					'title' => $this->titles['add'],
					'message' => $this->messages['no_user_categorie'],
				]);
			}
		} else {
			return view($this->testsCategoriesCreateEditBlade, [
				'title' => $this->titles['add'],
				'categories' => $categories,
			]);
		}
	}

	/**
	 * Função que ordena as categorias de testes recursivamente;
	 * @param $fatherId Identificador da categoria pai;
	 * @param $categories Array de categorias cadastradas;
	 * @return Array;
	 */
	private function sortRecursiveCategories($fatherId, $categories) {
		$newCategories = [];
		foreach ($categories as $categorie) {
			if ($categorie->father_id == $fatherId) {
				$categorie['childrens'] = $this->sortRecursiveCategories($categorie->id, $categories);
				$newCategories[] = $categorie;
			}
		}
		return $newCategories;
	}

	/**
	 * Função que armazena uma categoria de testes;
	 * @param Request $request
	 * @return Response;
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'description' => 'required',
		]);
		$input = $request->input();
		$input['user_id'] = \Auth::user()->id;
		if (!isset($input['father_id']) || $input['father_id'] == null) {
			$input['father_id'] = NULL;
		}
		$input['soft_delete'] = false;

		$categorie = TestCategorie::create($input);

		$categories = $this->getCategories();

		if ($categorie) {
			return view($this->testsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_created']]);
		} else {
			return view($this->testsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_no_created']]);
		}
	}

	/**
	 * Função que mostra o formulário para edição da categoria da testes;
	 * @param $id Identificador da categoria de testes;
	 * @return Response;
	 */
	public function show($id) {
		$message = null;
		$categorie = $this->getCategorie($id);
		$categories = $this->getCategories();
		if (count($categories) == 0) {
			$message = $this->messages['no_one'];
		}
		return view($this->testsCategoriesCreateEditBlade, ['title' => $this->titles['edit'], 'categorie' => $categorie, 'categories' => $categories, 'message' => $message]);
	}

	/**
	 * Função que atualiza a categoria de testes;
	 * @param $id Identificador da categoria de testes;
	 * @param Request $request;
	 * @return Response;
	 */
	public function update(Request $request, $id) {
		$this->validate($request, [
			'description' => 'required',
		]);

		$input = $request->input();
		if (!isset($input['father_id']) || $input['father_id'] == null) {
			$input['father_id'] = NULL;
		}

		$categorie = TestCategorie::where(['id' => $id])->first()->update($input);

		$categories = $this->getCategories();

		if ($categorie) {
			return view($this->testsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_updated']]);
		} else {
			return view($this->testsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_no_updated']]);
		}
	}

	/**
	 * Função que retorna a 'view' da confirmação para remoção da categoria;
	 * @param $id Identificador da categoria de testes;
	 * @return Response;
	 */
	public function confirm($id) {
		return view($this->testsCategoriesConfirmBlade, [
			'categorie' => $this->getCategorie($id),
		]);
	}

	/**
	 * Função de remoção da categoria através de 'soft delete';
	 * @param $id Identificador da categoria de testes;
	 * @return Response;
	 */
	public function destroy($id) {
		$categorie = TestCategorie::where(['id' => $id])->first()->update(['soft_delete' => true]);

		$categories = $this->getCategories();

		if ($categorie) {
			return view($this->testsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_deleted']]);
		} else {
			return view($this->testsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_no_deleted']]);
		}
	}
}
