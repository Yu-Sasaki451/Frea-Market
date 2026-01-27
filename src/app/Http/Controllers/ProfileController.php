<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showMypage(){
        return view('profile.mypage');
    }

    public function mypageEdit(){
        return view('profile.mypage_edit');
    }
}
