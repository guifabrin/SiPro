<?php

namespace App\Http\Controllers;

use App\QuestionsInTests;
use Illuminate\Http\Request;

class QuestionsInTestsController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function inTest($idTest, $idQuestion) {
		return QuestionsInTests::where(['test_id' => $idTest, 'question_id' => $idQuestion])->first() != null;
	}

	public function store(Request $request) {
		$input = $request->all();
		$qt = QuestionsInTests::create($input);
		die(($qt) ? true : false);
	}

	public function destroy(Request $request) {
		$input = $request->all();
		$qt = QuestionsInTests::where([
			"question_id" => $request->question_id,
			"test_id" => $request->test_id,
		])->delete();
		die(($qt) ? true : false);
	}
}
