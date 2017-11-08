<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Question;
use App\QuestionCategorie;

class QuestionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function read(Request $request)
    {
        return $this->readWithMessage($request,null,null);
    }

    public function readWithMessage(Request $request, $message, $status)
    {   
        if ($request->isMethod('post')) {
            \Session::put('message', $message);
            \Session::put('status', $status);
            return redirect()->to('/home/questions/');
        } else {
            $userId = \Auth::user()->id;

            $questions = null;
            $questionCategories = QuestionCategorie::where([
                'user_id' => $userId,
                'soft_delete' => 0
            ])->get();

            $max = 10;
            $page = $request->page;
            $selectedCategorie = $request->selectedCategorie;

            if (!isset($page))
                $page = 0;
            if (!isset($selectedCategorie))
                $selectedCategorie = 0;

            $prev = null;
            $curr= null;
            $next= null;
            if ($selectedCategorie!=0){
                $questions = Question::where([
                    'user_id'=>$userId,
                    'categorie_id'=>$request->selectedCategorie,
                    'soft_delete'=>0
                ])->paginate($max);
            } else {
                $questions = Question::where([
                    'user_id' => $userId,
                    'soft_delete' => 0
                ])->paginate($max);
            }

            if (isset($questions)){
                $prev = $questions->previousPageUrl();
                $curr = $questions->currentPage();
                $next = $questions->nextPageUrl();
            } else {
                $curr = 1;
            }
            return view('questions.view',['questionCategories'=>$questionCategories, 'questions'=>$questions, 'message'=> $message, 'status'=>$status, 'selectedCategorie'=>$selectedCategorie, 'prevPageUrl'=>$prev, 'currentPage'=> $curr, 'nextPageUrl'=>$next]);
        }
    }

    public function form(Request $request)
    {
        $id = $request->id;
        $userId = \Auth::user()->id;
        if (isset($id) &&  $id != ""){
            $questionQuery = Question::where([
                'user_id'=>$userId,
                'id'=> $id
            ]);
            $question = $questionQuery->first();
            if ($question){
                $questionCategorie = QuestionCategorie::where([
                    'id'=> $question->categorie_id, 
                    'user_id'=>$userId
                ])->first();

                $questionCategories = $this->getAllQuestionCategories();
                return view('questions.form', [
                    'question'=> $question,
                    'title'=> "Editar",
                    'questionCategories'=> $questionCategories,
                    'selectedCategorie'=> $request->selectedCategorie
                    ]);
            } else {
                return $this->readWithMessage($request, "A questão não pertence a você", "warning");
            }
        } else {
            $questionCategories = $this->getAllQuestionCategories();
            return view('questions.form', [
                    'title'=> "Adicionar",
                    'questionCategories'=> $questionCategories,
                    'selectedCategorie'=> $request->selectedCategorie
                    ]);
        }
    }

    private function getAllQuestionCategories(){
        $userId = \Auth::user()->id;
        return QuestionCategorie::where([
                'user_id'=>$userId,
                'soft_delete'=>0
            ])->get();
    }

    public function createOrUpdate(Request $request)
    {
        $input = $request->all();
        $userId = \Auth::user()->id;

        if (isset($input['id']) &&  $input['id'] != ""){
            $id = $input['id'];
            unset($input['_token']);
            unset($input['answer_type']);
            unset($input['lines_number']);
            unset($input['input_answer']);

            $questionQuery = Question::where([
                'user_id'=>$userId,
                'id'=> $id
            ]);
            $question = $questionQuery->first();

            if ($question){
                $questionCategorie = QuestionCategorie::where([
                    'user_id'=>$userId,
                    'id'=> $question->categorie_id
                ])->first();

                if (!isset($input['soft_delete'])){
                    $input['soft_delete']=0;
                }

                $question = $questionQuery->update($input);
                if ($input['soft_delete'] == 1){
                    if ($question){
                        $message = "Questão removida.";
                        $status = "success";
                    } else {
                        $message = "Questão não removida.";
                        $status = "danger";
                    }
                } else {
                    if ($question){
                        $message = "Questão atualizada.";
                        $status = "success";
                    } else {
                        $message = "Questão não atualizada.";
                        $status = "danger";
                    }
                }
            } else {
                $message = "A questão não pertence a você.";
                $status = "warning";
            }
        } else {
            $input['user_id'] = $userId;
            $input['soft_delete'] = 0;
            $question = Question::create($input);
            if ($question){
                $message = "Questão criada.";
                $status = "success";
            } else {
                $message = "Questão não criada.";
                $status = "danger";
            }
        }
        return $this->readWithMessage($request, $message, $status);
    }

    public function confirm(Request $request)
    {
        $id = $request->id;
        $userId = \Auth::user()->id;
        $questionQuery = Question::where([
            'user_id'=>$userId, 
            'id'=> $id
        ]);
        $question = $questionQuery->first();
        if ($question){
            return view('questions.confirm', [
                'question'=> $question,
                ]);
        } else {
            return $this->readWithMessage($request, "A questão não pertence a você.", "warning");
        }
    }

    public function delete(Request $request)
    {
        return $this->createOrUpdate($request);
    }
}