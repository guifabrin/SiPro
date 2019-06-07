<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\CategoryController;

class QuestionCategoryController extends CategoryController
{
    protected $type = "question";
    protected $model = "App\QuestionCategory";
}