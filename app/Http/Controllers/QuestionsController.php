<?php

namespace App\Http\Controllers;

use App\Image;
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
		'image_no_created' => [
			'status' => 'danger',
			'message' => 'Imagem não criada.',
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
		$question = Question::where($args)->first();
		$question['image'] = Image::where(['id' => $question->image_id])->first();
		return $question;
	}

	/**
	 * Função de retorno de opções de uma quetão
	 * @return Array
	 */
	private function getOptions($id) {
		$args = ['question_id' => $id];
		$options = Option::where($args)->get();
		foreach ($options as $option) {
			$option['image'] = Image::where(['id' => $option->image_id])->first();
		}
		return $options;
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
		$questions = Question::where($args)->paginate(15);
		foreach ($questions as $question) {
			$question['image'] = Image::where(['id' => $question->image_id])->first();
		}
		return $questions;
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

	private function endDB($commit, $message, $categorie) {
		if ($commit) {
			DB::commit();
		} else {
			DB::rollBack();
		}
		$questions = $this->getQuestions(($categorie == null) ? null : $categorie->id);
		$categories = $this->questionCategoriesController->getCategories();
		return view($this->questionsViewBlade, ['categorie' => ($categorie == null) ? null : $categorie, 'categories' => $categories, 'questions' => $questions, 'message' => $message]);
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

		DB::beginTransaction();
		$image = null;
		$categorie = $this->questionCategoriesController->getCategorie($input['categorie_id']);
		if (isset($input['image'])) {
			$imageInput = [];
			$imageInput['imageb64'] = $this->imageController->convert64($input['image']);
			$this->imageController->makeThumb($input['image'], $input['image'] . ".tmp", 100);
			$imageInput['imageb64_thumb'] = $this->imageController->convert64($input['image'] . ".tmp");
			$image = Image::where($imageInput)->first();
			if (!$image) {
				$image = Image::create($imageInput);
			}

			unset($input['image']);
			if ($image) {
				$input['image_id'] = $image->id;
			} else {
				return $this->endDB(false, $this->messages['image_not_created'], $categorie);
			}
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
		unset($input['option-id']);

		$input['soft_delete'] = false;
		$question = Question::create($input);

		if ($question) {
			$allCreate = true;
			if ($input['type'] != 0) {
				for ($i = 0; $i < 5; $i++) {
					$imageOptionId = null;
					if (isset($options['image'][$i])) {
						$imageOptionInput = [];
						$imageOptionInput['imageb64'] = $this->imageController->convert64($options['image'][$i]);
						$this->imageController->makeThumb($options['image'][$i], $options['image'][$i] . ".tmp", 100);
						$imageOptionInput['imageb64_thumb'] = $this->imageController->convert64($options['image'][$i] . ".tmp");
						$imageOption = Image::where($imageOptionInput)->first();
						if (!$image) {
							$imageOption = Image::create($imageOptionInput);
						}
						if ($imageOption) {
							$imageOptionId = $imageOption->id;
						} else {
							return $this->endDB(false, $this->messages['image_not_created'], $categorie);
						}
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
						'image_id' => $imageOptionId,
						'correct' => $optionCorrect,
					]);
					if (!$option) {
						return $this->endDB(false, $this->messages['options_no_created'], $categorie);
					}
				}
			}
			return $this->endDB(true, $this->messages['question_created'], $categorie);
		} else {
			return $this->endDB(false, $this->messages['question_no_created'], $categorie);
		}
	}

	/**
	 * Função que atualiza a questão;
	 * @param $id Identificador da questão;
	 * @param Request $request;
	 * @return Response;
	 */
	public function update(Request $request, $id) {
		$this->validate($request, [
			'description' => 'required',
			'lines' => 'required',
			'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
		]);

		$input = $request->except(['_method', '_token']);
		if ($input['type'] != 0) {
			$rules = [];
			for ($i = 0; $i < 5; $i++) {
				$rules['option-id.' . $i] = 'required';
				$rules['option-description.' . $i] = 'required';
			}
			$rules['option-correct'] = 'required';
			$this->validate($request, $rules);
		}

		if (!isset($input['categorie_id']) || $input['categorie_id'] == "null") {
			$input['categorie_id'] = NULL;
		}

		$input['user_id'] = \Auth::user()->id;

		DB::beginTransaction();
		$image = null;
		$categorie = $this->questionCategoriesController->getCategorie($input['categorie_id']);
		if (isset($input['image'])) {
			$imageInput = [];
			$imageInput['imageb64'] = $this->imageController->convert64($input['image']);
			$this->imageController->makeThumb($input['image'], $input['image'] . ".tmp", 100);
			$imageInput['imageb64_thumb'] = $this->imageController->convert64($input['image'] . ".tmp");
			$image = Image::where($imageInput)->first();
			if (!$image) {
				$image = Image::create($imageInput);
			}

			unset($input['image']);
			if ($image) {
				$input['image_id'] = $image->id;
			} else {
				return $this->endDB(false, $this->messages['image_not_updated'], $categorie);
			}
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

		if (isset($input['option-id'])) {
			$options['id'] = $input['option-id'];
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
		unset($input['option-id']);
		$question = $this->getQuestion($id);
		$allSame = true;
		if ($allSame && $question->categorie_id != $input['categorie_id']) {
			$allSame = false;
		}
		if ($allSame && $question->description != $input['description']) {
			$allSame = false;
		}
		if ($allSame && $question->type != $input['type']) {
			$allSame = false;
		}
		if ($allSame && $question->lines != $input['lines']) {
			$allSame = false;
		}
		if ($allSame && $question->lines != $input['lines']) {
			$allSame = false;
		}
		if (!$allSame) {
			$question = Question::where(['id' => $id, 'user_id' => $input['user_id']])->update($input);
		}

		if ($question) {
			$allCreate = true;
			if ($input['type'] != 0) {
				for ($i = 0; $i < 5; $i++) {
					$imageOptionId = null;
					if (isset($options['image'][$i])) {
						$imageOptionInput = [];
						$imageOptionInput['imageb64'] = $this->imageController->convert64($options['image'][$i]);
						$this->imageController->makeThumb($options['image'][$i], $options['image'][$i] . ".tmp", 100);
						$imageOptionInput['imageb64_thumb'] = $this->imageController->convert64($options['image'][$i] . ".tmp");
						$imageOption = Image::where($imageOptionInput)->first();
						if (!$image) {
							$imageOption = Image::create($imageOptionInput);
						}
						if ($imageOption) {
							$imageOptionId = $imageOption->id;
						} else {
							return $this->endDB(false, $this->messages['image_not_updated'], $categorie);
						}
					}
					$optionCorrect = false;
					for ($j = 0; $j < count($options['correct']); $j++) {
						if ($options['correct'][$j] == $i) {
							$optionCorrect = true;
							break;
						}
					}
					$args = [];
					$args['description'] = $options['description'][$i];
					if ($imageOptionId != null) {
						$args['image_id'] = $imageOptionId;
					}
					$args['correct'] = $optionCorrect;
					$option = Option::where(['id' => $options['id'][$i]])->update($args);
					if (!$option) {
						return $this->endDB(false, $this->messages['options_no_updated'], $categorie);
					}
				}
			}
			return $this->endDB(true, $this->messages['question_updated'], $categorie);
		} else {
			return $this->endDB(false, $this->messages['question_no_updated'], $categorie);
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

	/**
	 * Função que retorna a 'view' da confirmação para remoção da questão;
	 * @param $id Identificador da questão;
	 * @return Response;
	 */
	public function confirm($id) {
		return view($this->questionsConfirmBlade, [
			'question' => $this->getQuestion($id),
		]);
	}

	/**
	 * Função de remoção da questão através de 'soft delete';
	 * @param $id Identificador da categoria de questão;
	 * @return Response;
	 */
	public function destroy($id) {
		$question = Question::where(['id' => $id, 'user_id' => \Auth::user()->id])->first()->update(['soft_delete' => true]);

		DB::beginTransaction();
		if ($question) {
			return $this->endDB(true, $this->messages['question_deleted'], null);
		} else {
			return $this->endDB(false, $this->messages['question_no_deleted'], null);
		}
	}
}