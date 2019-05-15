<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function logout(){
        Auth::logout();
        return view('home.welcome');
    }

    public function policy(){
        return view('home.policy');
    }

    public function welcome(){
        return view('home.welcome');
    }
}