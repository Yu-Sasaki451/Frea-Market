<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register_step1(){
        return view('auth.register_step1');
    }

    public function register_step2(){
        return view('auth.register_step2');
    }

    public function login(){
        return view('auth.login');
    }
}
