<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\CategoryController;

class TestCategoryController extends CategoryController
{

    protected $type = "test";
    protected $model = "App\TestCategory";
}
