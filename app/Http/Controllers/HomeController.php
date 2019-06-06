<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends ApplicationController
{
    public function welcome(){
        return view('home.welcome');
    }
}