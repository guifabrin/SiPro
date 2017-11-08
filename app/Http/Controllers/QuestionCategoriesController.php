<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\QuestionCategorie;
use App\Question;

class QuestionCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function read(Request $request)
    {
        $categories = QuestionCategorie::where(['user_id'=>\Auth::user()->id,'soft_delete'=>0])->get();
        $tree = [];
        $this->recursiveSelectValues($tree, $categories, 0, 0, 0);
        return view('questions.categories.view',['categories'=>$categories, 'tree'=>json_encode($tree)]);
    }
    
    public function readWithMessage(Request $request, $message, $status)
    { 
        if ($request->isMethod('post')) {
            \Session::put('message', $message);
            \Session::put('status', $status);
            return redirect()->to('/home/questions/categories');
        } else {
            $categories = QuestionCategorie::where(['user_id'=>\Auth::user()->id,'soft_delete'=>0])->get();
            $tree = [];
            $this->recursiveSelectValues($tree, $categories, 0, 0, 0);
            return view('questions.categories.view',['categories'=>$categories, 'tree'=>json_encode($tree), 'message'=> $message, 'status'=>$status]);
        }
    }

    public function form(Request $request)
    {
        $id = $request->id;
        $categories = QuestionCategorie::where(['user_id'=>\Auth::user()->id, 'soft_delete'=>0])->get();
        if (isset($id) &&  $id != ""){
            $questionQuery = QuestionCategorie::where(['id'=> $id, 'soft_delete'=>0, 'user_id'=>\Auth::user()->id]);
            $question = $questionQuery->first();
            if ($question){
                return view('questions.categories.form', [
                    'question'=> $question,
                    'title'=> "Editar",
                    'categories'=> $categories,
                    ]);
            } else {
                return $this->readWithMessage($request, "A categoria da questão não pertence a você", "warning");
            }
        } else {
            return view('questions.categories.form', [
                    'question'=> null,
                    'title'=> "Adicionar",
                    'categories'=> $categories,
                    ]);
        }
    }

    public function createOrUpdate(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = \Auth::user()->id;
        if (!isset($input['father_id']) || $input['father_id']==null)
            $input['father_id'] = NULL;
        $id = $input['id'];

        if (isset($id) &&  $id != ""){
            unset($input['_token']);
            $questionQuery = QuestionCategorie::where(['id'=> $id, 'user_id'=>\Auth::user()->id]);
            $question = $questionQuery->update($input);
            if ($input['soft_delete']==1){
                if ($question){
                    $message = "Categoria de questão removida.";
                    $status = "success";
                } else {
                    $message = "Categoria de questão não removida.";
                    $status = "danger";
                }
            } else {
                if ($question){
                    $message = "Categoria de questão atualizada.";
                    $status = "success";
                } else {
                    $message = "Categoria de questão não atualizada.";
                    $status = "danger";
                }
            }
        } else {
            $input['soft_delete'] = false;
            $question = QuestionCategorie::create($input);
            if ($question){
                $message = "Categoria de questão criada.";
                $status = "success";
            } else {
                $message = "Categoria de questão não criada.";
                $status = "danger";
            }
        }
        return $this->readWithMessage($request, $message, $status);
    }

    private function recursiveSelectValues(&$tree, $categories, $father_id, $nivel, $id){
        foreach($categories as $categorie){
            if ($categorie->id == $id)
                continue;
            if ($categorie->father_id == $father_id && $categorie->soft_delete == 0){
                if (!isset($tree))
                    $tree = array();
                $node = array();
                $node["id"] = $categorie->id;
                $node["text"] = $categorie->description;
                $this->recursiveSelectValues($node["nodes"], $categories, $categorie->id, $nivel+1,$id);
                array_push($tree, $node);
            }
        }
    }

    public function confirm(Request $request)
    {
        $id = $request->id;
        $questionQuery = QuestionCategorie::where(['id'=> $id, 'user_id'=>\Auth::user()->id]);
        $question = $questionQuery->first();

        return view('questions.categories.confirm', [
                'question'=> $question,
                ]);
    }

    public function delete(Request $request)
    {
        return $this->createOrUpdate($request);
    }
}
