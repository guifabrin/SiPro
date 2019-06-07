<?php

namespace App\Http\Controllers;

class QuestionController extends ItemCategoryController {
    protected $type = "question";
    protected $class = "App\\Question";
    protected $storer = "App\\Helpers\\QuestionStore";
}