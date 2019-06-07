<?php

namespace App\Http\Controllers;

class QuestionCategoryController extends CategoryController {
    protected $type = "question";
    protected $model = "App\QuestionCategory";
}