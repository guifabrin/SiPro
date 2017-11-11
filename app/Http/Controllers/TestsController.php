<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Test;
use App\Question;
use App\TestCategorie;
use App\QuestionCategorie;
use App\QuestionsInTests;

class TestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function read(Request $request)
    {
        return $this->readWithMessage($request, null, null);
    }

    public function readWithMessage(Request $request, $message, $status)
    { 
        if ($request->isMethod('post')) {
            \Session::put('message', $message);
            \Session::put('status', $status);
            return redirect()->to('/home/tests');
        } else {
            $userId = \Auth::user()->id;
            $categories = TestCategorie::where([
                'user_id'=>$userId,
                'soft_delete'=>0
            ])->get();

            $tests = Test::where([
                'user_id'=>$userId,
                'soft_delete'=>0
            ])->get();

            return view('tests.view',[
                'categories'=>$categories, 
                'tests'=>$tests,
                'message'=>$message,
                'status' => $status
            ]);
        }
    }

    public function form(Request $request)
    {
        return $this->formView($request, null, null);
    }
    
    private function formView($request, $message, $status)
    {
        $userId = \Auth::user()->id;
        $test = null;
        $id = $request->id;
        $title = "Adicionar";

        if (isset($id) && $id != ""){
            $testQuery = Test::where([
                'user_id'=>$userId,
                'id'=> $id
            ]);
            $test = $testQuery->first();
            $title = "Editar";
        }

        $test_categories = TestCategorie::where([
            'user_id'=>$userId,
            'soft_delete'=>0
        ])->get();

        $question_categories = QuestionCategorie::where([
            'user_id'=>$userId,
            'soft_delete'=>0
        ])->get();

        if ($test != null){
            return view('tests.form', [
                'test'=> $test,
                'title'=> $title,
                'test_categories'=> $test_categories,
                'question_categories'=> $question_categories, 'message'=>$message, 'status' => $status, 'selected_categorie' => $request->selected_categorie
                ]);
        } else {
            return view('tests.form', [
                'title'=> $title,
                'test_categories'=> $test_categories, 'message'=>$message, 'status' => $status, 'selected_categorie' => $request->selected_categorie
                ]);

        }
    }

    public function createOrUpdate(Request $request)
    {
        $userId = \Auth::user()->id;
        $input = $request->all();
        if (isset($input['id']) &&  $input['id'] != ""){

            $id = $input['id'];
            unset($input['_token']);
            unset($input['answer_type']);
            unset($input['lines_number']);
            unset($input['input_answer']);

            $testQuery = Test::where([
                'user_id'=>$userId,
                'id'=> $id
            ]);

            if(!isset($input['soft_delete'])){
                $input['soft_delete'] = 0;
            }
            $test = $testQuery->update($input);
            if ($input['soft_delete']==1){
                if ($test){
                    $message = "Avaliação removida.";
                    $status = "success";
                } else {
                    $message = "Avaliação não removida.";
                    $status = "danger";
                }
            } else {
                if ($test){
                    $message = "Avaliação atualizada.";
                    $status = "success";
                } else {
                    $message = "Avaliação não atualizada.";
                    $status = "danger";
                }
            }
            return $this->readWithMessage($request,$message,$status);
        } else {
            $input['user_id'] = $userId;
            $test = Test::create($input);
            if ($test){
                $message = "Avaliação criada.";
                $status = "success";
                return redirect()->to('/home/tests/update/'.$test->id);
            } else {
                $message = "Avaliação não criada.";
                $status = "danger";
                return $this->formView($request, $message, $status);
            }
        }
    }

    public function confirm(Request $request)
    {
        $userId = \Auth::user()->id;
        $id = $request->id;
        $testQuery = Test::where([
            'user_id'=>$userId,
            'id'=> $id
        ]);
        $test = $testQuery->first();

        return view('tests.confirm', [
            'test'=> $test,
        ]);
    }

    public function delete(Request $request)
    {
        return $this->createOrUpdate($request);
    }

    public function show(Request $request){
        $userId = \Auth::user()->id;
        $id = $request->id;
        if (isset($id) && $id != ""){
            $testQuery = Test::where([
                'user_id'=>$userId,
                'id'=> $id
            ]);
            $test = $testQuery->first();
            return view('tests.show', [
                'test'=> $test
                ]);
        } else {
            return view('tests.show', [
                'test'=> null
                ]);
        }
    }

    public function showData(Request $request){
        $userId = \Auth::user()->id;
        $id = $request->id;
        if (isset($id) && $id != ""){
            $testQuery = Test::where([
                'user_id'=>$userId,
                'id'=> $id
            ]);
            $test = $testQuery->first();
            $questions_in_teste = QuestionsInTests::where([
                'test_id'=>$id
            ])->get();
            $query = null;
            foreach($questions_in_teste as $qt){
                if ($query == null){
                    $query = Question::where([
                        'user_id'=>$userId,
                        'id'=>$qt->question_id,
                        'soft_delete'=>0
                    ]);
                }
                else{
                    $query->orWhere([
                        'user_id'=>$userId,
                        'id'=>$qt->question_id,
                        'soft_delete'=>0
                        ]);
                }
            }
            $questions = $query->get();
            return view('tests.data', [
                'test'=> $test,
                'questions_in_tests'=> $questions_in_teste,
                'questions'=> $questions,
                ]);
        } else {
            return view('tests.data', [
                'test'=> null,
                'questions_in_teste'=>null,
                'questions'=>null
                ]);
        }
    }
}
