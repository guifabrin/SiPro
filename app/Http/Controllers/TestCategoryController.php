<?php

namespace App\Http\Controllers;

class TestCategoryController extends CategoryController {

    protected $type = "test";
    protected $model = "App\TestCategory";
}
