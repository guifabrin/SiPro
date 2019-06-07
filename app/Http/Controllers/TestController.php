<?php

namespace App\Http\Controllers;

class TestController extends ItemCategoryController {
    protected $type = "test";
    protected $class = "App\\Test";
    protected $storer = "App\\Http\\Helpers\\TestSaver";
}