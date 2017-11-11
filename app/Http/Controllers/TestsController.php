<?php

namespace App\Http\Controllers;

use App\Image;
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
		'image_no_created' => [
			'status' => 'danger',
			'message' => 'Imagem não criado.',
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

	private $imageController = null;
	private $testCategoriesController = null;

	/**
	 * Construtor
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->testCategoriesController = new TestCategoriesController();
		$this->imageController = new ImageController();
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
		$test = Test::where($args)->first();
		$test['image'] = Image::where(['id' => $test->image_id])->first();
		return $test;
	}

	/**
	 * Função de retorno de opções de uma quetão
	 * @return Array
	 */
	private function getOptions($id) {
		$args = ['test_id' => $id];
		$options = Option::where($args)->get();
		foreach ($options as $option) {
			$option['image'] = Image::where(['id' => $option->image_id])->first();
		}
		return $options;
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
			$test['image'] = Image::where(['id' => $test->image_id])->first();
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
		$categories = null;
		if (isset($id)) {
			$categorie = $this->testCategoriesController->getCategorie($id);
		} else {
			$categories = $this->testCategoriesController->getCategories();
		}

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
		$categorie = $this->testCategoriesController->getCategorie($input['categorie_id']);
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
		$test = Test::create($input);

		if ($test) {
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
						'test_id' => $test->id,
						'description' => $options['description'][$i],
						'image_id' => $imageOptionId,
						'correct' => $optionCorrect,
					]);
					if (!$option) {
						return $this->endDB(false, $this->messages['options_no_created'], $categorie);
					}
				}
			}
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
		$categorie = $this->testCategoriesController->getCategorie($input['categorie_id']);
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
		$test = $this->getTest($id);
		$allSame = true;
		if ($allSame && $test->categorie_id != $input['categorie_id']) {
			$allSame = false;
		}
		if ($allSame && $test->description != $input['description']) {
			$allSame = false;
		}
		if ($allSame && $test->type != $input['type']) {
			$allSame = false;
		}
		if ($allSame && $test->lines != $input['lines']) {
			$allSame = false;
		}
		if ($allSame && $test->lines != $input['lines']) {
			$allSame = false;
		}
		if (!$allSame) {
			$test = Test::where(['id' => $id, 'user_id' => $input['user_id']])->update($input);
		}

		if ($test) {
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
		$options = $this->getOptions($id);
		$categorie = $this->testCategoriesController->getCategorie($test->categorie_id);
		$categories = $this->testCategoriesController->getCategories();
		return view($this->testsCreateEditBlade, ['title' => $this->titles['edit'], 'test' => $test, 'options' => $options, 'categorie' => $categorie, 'categories' => $categories]);
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