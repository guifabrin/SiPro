<?php

namespace App\Http\Controllers;

use App\QuestionCategorie;
use Illuminate\Http\Request;

class QuestionCategoriesController extends Controller {
	/**
	 * Variáveis de caminho dos arquivos Blade
	 */
	private $questionsCategoriesViewBlade = "questions.categories.view";
	private $questionsCategoriesCreateEditBlade = "questions.categories.form";
	private $questionsCategoriesConfirmBlade = 'questions.categories.confirm';

	/**
	 * Array de mensagens de retorno das ações executadas no QuestionCategoriesController
	 */
	private $messages = [
		'no_one' => [
			'status' => 'warning',
			'message' => 'Não há nenhuma categoria de questão cadastrada.',
		],
		'no_user_categorie' => [
			'status' => 'warning',
			'message' => 'A categoria da questão não pertence a você.',
		],
		'categorie_created' => [
			'status' => 'success',
			'message' => 'Categoria de questão criada.',
		],
		'categorie_no_created' => [
			'status' => 'danger',
			'message' => 'Categoria de questão não criada.',
		],
		'categorie_updated' => [
			'status' => 'success',
			'message' => 'Categoria de questão atualizada.',
		],
		'categorie_no_updated' => [
			'status' => 'danger',
			'message' => 'Categoria de questão não atualizada.',
		],
		'categorie_deleted' => [
			'status' => 'success',
			'message' => 'Categoria de questão removida.',
		],
		'categorie_no_deleted' => [
			'status' => 'danger',
			'message' => 'Categoria de questão não removida.',
		],
	];

	/**
	 * Array de titulos do QuestionCategoriesController
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
	 * Função de retorno da visualização de categorias de questões;
	 * @return Response
	 */
	public function index(Request $request) {
		$message = null;
		$categories = $this->getCategories();
		if (count($categories) == 0) {
			$message = $this->messages['no_one'];
		}
		return view($this->questionsCategoriesViewBlade, ['categories' => $categories, 'message' => $message]);
	}

	/**
	 * Função de retorno de uma categoria
	 * @return Categorie
	 */
	public function getCategorie($id) {
		$args = ['id' => $id, 'user_id' => \Auth::user()->id, 'soft_delete' => 0];
		return QuestionCategorie::where($args)->first();
	}

	/**
	 * Função de retorno de todas as categorias do usuário;
	 * @return Array
	 */
	public function getCategories() {
		$args = ['user_id' => \Auth::user()->id, 'soft_delete' => 0];
		return $this->sortRecursiveCategories(null, QuestionCategorie::where($args)->get());
	}

	/**
	 * Função que retorna a 'view' de criação da categoria da questão;
	 * @param Request $request;
	 * @return Response;
	 */
	public function create(Request $request) {
		$paiId = $request->id;
		$categories = $this->getCategories();

		if (isset($paiId) && $paiId != "") {
			$categorie = $this->getCategorie($paiId);
			if ($categorie) {
				return view($this->questionsCategoriesCreateEditBlade, [
					'title' => $this->titles['edit'],
					'fatherCategorie' => $categorie,
					'categories' => $categories,
				]);
			} else {
				return view($this->questionsCategoriesCreateEditBlade, [
					'title' => $this->titles['add'],
					'message' => $this->messages['no_user_categorie'],
				]);
			}
		} else {
			return view($this->questionsCategoriesCreateEditBlade, [
				'title' => $this->titles['add'],
				'categories' => $categories,
			]);
		}
	}

	/**
	 * Função que ordena as categorias de questão recursivamente;
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
	 * Função que armazena uma categoria de questão;
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

		$categorie = QuestionCategorie::create($input);

		$categories = $this->getCategories();

		if ($categorie) {
			return view($this->questionsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_created']]);
		} else {
			return view($this->questionsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_no_created']]);
		}
	}

	/**
	 * Função que mostra o formulário para edição da categoria da questão;
	 * @param $id Identificador da categoria de questão;
	 * @return Response;
	 */
	public function show($id) {
		$message = null;
		$categorie = $this->getCategorie($id);
		$categories = $this->getCategories();
		if (count($categories) == 0) {
			$message = $this->messages['no_one'];
		}
		return view($this->questionsCategoriesCreateEditBlade, ['title' => $this->titles['edit'], 'categorie' => $categorie, 'categories' => $categories, 'message' => $message]);
	}

	/**
	 * Função que atualiza a categoria de questão;
	 * @param $id Identificador da categoria de questão;
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

		$categorie = QuestionCategorie::where(['id' => $id])->first()->update($input);

		$categories = $this->getCategories();

		if ($categorie) {
			return view($this->questionsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_updated']]);
		} else {
			return view($this->questionsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_no_updated']]);
		}
	}

	/**
	 * Função que retorna a 'view' da confirmação para remoção da categoria;
	 * @param $id Identificador da categoria de questão;
	 * @return Response;
	 */
	public function confirm($id) {
		return view($this->questionsCategoriesConfirmBlade, [
			'categorie' => $this->getCategorie($id),
		]);
	}

	/**
	 * Função de remoção da categoria através de 'soft delete';
	 * @param $id Identificador da categoria de questão;
	 * @return Response;
	 */
	public function destroy($id) {
		$categorie = QuestionCategorie::where(['id' => $id])->first()->update(['soft_delete' => true]);

		$categories = $this->getCategories();

		if ($categorie) {
			return view($this->questionsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_deleted']]);
		} else {
			return view($this->questionsCategoriesViewBlade,
				['categories' => $categories, 'message' => $this->messages['categorie_no_deleted']]);
		}
	}
}
