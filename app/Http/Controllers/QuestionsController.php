<?php

namespace App\Http\Controllers;

use App\Option;
use App\Question;
use DB;
use Illuminate\Http\Request;

class QuestionsController extends Controller {

	/**
	 * Variáveis de caminho dos arquivos Blade
	 */
	private $questionsViewBlade = "questions.view";
	private $questionsCreateEditBlade = "questions.form";
	private $questionsConfirmBlade = 'questions.confirm';

	/**
	 * Array de mensagens de retorno das ações executadas no QuestionsController
	 */
	private $messages = [
		'no_one' => [
			'status' => 'warning',
			'message' => 'Não há nenhuma questão cadastrada.',
		],
		'no_user_question' => [
			'status' => 'warning',
			'message' => 'A questão não pertence a você.',
		],
		'question_created' => [
			'status' => 'success',
			'message' => 'Questão criada.',
		],
		'options_no_created' => [
			'status' => 'success',
			'message' => 'Questão criada.',
		],
		'question_no_created' => [
			'status' => 'danger',
			'message' => 'Questão não criada.',
		],
		'question_updated' => [
			'status' => 'success',
			'message' => 'Questão atualizada.',
		],
		'question_no_updated' => [
			'status' => 'danger',
			'message' => 'Questão não atualizada.',
		],
		'question_deleted' => [
			'status' => 'success',
			'message' => 'Questão removida.',
		],
		'question_no_deleted' => [
			'status' => 'danger',
			'message' => 'Questão não removida.',
		],
	];

	/**
	 * Array de titulos do QuestionsController
	 */
	private $titles = [
		'add' => 'Adicionar',
		'edit' => 'Editar',
	];

	private $imageController = null;
	private $questionCategoriesController = null;

	/**
	 * Construtor
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->questionCategoriesController = new QuestionCategoriesController();
		$this->imageController = new ImageController();
	}

	/**
	 * Função de retorno da visualização de todas as questões;
	 * @return Resonse
	 */
	public function index(Request $request) {
		return $this->index_(null);
	}

	/**
	 * Função de retorno da visualização de questões da categoria selecionada;
	 * @return Response
	 */
	public function index_($id) {
		$message = null;
		$questions = $this->getQuestions($id);

		$categorie = null;
		$categories = $this->questionCategoriesController->getCategories();

		if ($id != null) {
			$categorie = $this->questionCategoriesController->getCategorie($id);
		}

		if (count($questions) == 0) {
			$message = $this->messages['no_one'];
		}

		return view($this->questionsViewBlade, ['categorie' => $categorie, 'categories' => $categories, 'questions' => $questions, 'message' => $message]);
	}

	/**
	 * Função de retorno de uma questão
	 * @return Question
	 */
	private function getQuestion($id) {
		$args = ['id' => $id, 'user_id' => \Auth::user()->id, 'soft_delete' => 0];
		return Question::where($args)->first();
	}

	/**
	 * Função de retorno de opções de uma quetão
	 * @return Array
	 */
	private function getOptions($id) {
		$args = ['question_id' => $id];
		return Option::where($args)->get();
	}

	/**
	 * Função de retorno de todas as questões do usuário;
	 * @return Array
	 */
	private function getQuestions($categorieId) {
		$args;
		if ($categorieId == null) {
			$args = ['user_id' => \Auth::user()->id, 'soft_delete' => 0];
		} else {
			$args = ['user_id' => \Auth::user()->id, 'soft_delete' => 0, 'categorie_id' => $categorieId];
		}
		return Question::where($args)->paginate(15);
	}

	/**
	 * Função que retorna a 'view' de criação da categoria da questão;
	 * @param Request $request;
	 * @return Response;
	 */
	public function create(Request $request) {
		return $this->create_(null);
	}

	/**
	 * Função que retorna a 'view' de criação da categoria da questão;
	 * @param Request $request;
	 * @return Response;
	 */
	public function create_($id) {
		$categorie = null;
		$categories = null;
		if (isset($id)) {
			$categorie = $this->questionCategoriesController->getCategorie($id);
		} else {
			$categories = $this->questionCategoriesController->getCategories();
		}

		return view($this->questionsCreateEditBlade, ['title' => $this->titles['add'], 'categorie' => $categorie, 'categories' => $categories]);
	}

	/**
	 * Função que armazena uma categoria de questão;
	 * @param Request $request
	 * @return Response;
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'description' => 'required',
			'lines' => 'required',
			'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
		]);

		$input = $request->all();
		if ($input['type'] != 0) {
			$rules = [];
			for ($i = 0; $i < 5; $i++) {
				$rules['option-description.' . $i] = 'required';
			}
			$rules['option-correct'] = 'required';
			$this->validate($request, $rules);
		}

		if (!isset($input['categorie_id']) || $input['categorie_id'] == "null") {
			$input['categorie_id'] = NULL;
		}

		$input['user_id'] = \Auth::user()->id;
		if (isset($input['image'])) {
			$input['imageb64'] = $this->imageController->convert64($input['image']);
			$this->imageController->makeThumb($input['image'], $input['image'] . ".tmp", 100);
			$input['imageb64_thumb'] = $this->imageController->convert64($input['image'] . ".tmp");
			unset($input['image']);
		}

		$options = [];
		if (isset($input['option-description'])) {
			$options['description'] = $input['option-description'];
		}

		if (isset($input['option-image'])) {
			$options['image'] = $input['option-image'];
		}

		if (isset($input['option-correct'])) {
			$options['correct'] = $input['option-correct'];
		}

		switch ($input['type']) {
		case 1:
		case 2:
			$input['lines'] = -1;
			break;
		}
		unset($input['option-description']);
		unset($input['option-image']);
		unset($input['option-correct']);

		$input['soft_delete'] = false;

		DB::beginTransaction();
		$question = Question::create($input);
		$categorieId = $input['categorie_id'];
		$categorie = $this->questionCategoriesController->getCategorie($categorieId);
		$categories = $this->questionCategoriesController->getCategories();
		$questions = $this->getQuestions($categorieId);

		if ($question) {
			$allCreate = true;
			if ($input['type'] != 0) {
				for ($i = 0; $i < 5; $i++) {
					$optionImageb64 = null;
					$optionImageb64Thumb = null;
					if (isset($options['image'][$i])) {
						$optionImageb64 = $this->imageController->convert64($options['image'][$i]);
						$this->imageController->makeThumb($options['image'][$i], $options['image'][$i] . ".tmp", 100);
						$optionImageb64Thumb = $this->imageController->convert64($options['image'][$i] . ".tmp");
						unset($input['image']);
					}
					$optionCorrect = false;
					for ($j = 0; $j < count($options['correct']); $j++) {
						if ($options['correct'][$j] == $i) {
							$optionCorrect = true;
							break;
						}
					}
					$option = Option::create([
						'question_id' => $question->id,
						'description' => $options['description'][$i],
						'imageb64' => $optionImageb64,
						'imageb64_thumb' => $optionImageb64Thumb,
						'correct' => $optionCorrect,
					]);
					if (!$option) {
						DB::rollBack();
						return view($this->questionsViewBlade, ['categorie' => $categorie, 'categories' => $categories, 'questions' => $questions, 'message' => $this->messages['options_no_created']]);
					}
				}
			}
			DB::commit();
			return view($this->questionsViewBlade, ['categorie' => $categorie, 'categories' => $categories, 'questions' => $questions, 'message' => $this->messages['question_created']]);
		} else {
			DB::rollBack();
			return view($this->questionsViewBlade, ['categorie' => $categorie, 'categories' => $categories, 'questions' => $questions, 'message' => $this->messages['question_no_created']]);
		}
	}

	/**
	 * Função que mostra o formulário para edição da questão;
	 * @param $id Identificador da questão;
	 * @return Response;
	 */
	public function show($id) {
		$message = null;
		$question = $this->getQuestion($id);
		$options = $this->getOptions($id);
		$categorie = $this->questionCategoriesController->getCategorie($question->categorie_id);
		$categories = $this->questionCategoriesController->getCategories();
		return view($this->questionsCreateEditBlade, ['title' => $this->titles['edit'], 'question' => $question, 'options' => $options, 'categorie' => $categorie, 'categories' => $categories]);
	}
}