<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showMypage(){
        $profile = Profile::where('user_id',Auth::id())->first();
        return view('profile.mypage',compact('profile'));
    }

    public function mypageEdit(){
        $profile = Profile::where('user_id',Auth::id())->first();
        return view('profile.mypage_edit',compact('profile'));
    }

    public function storeProfile(Request $request){
    $userId = auth()->id();

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('profiles', 'public');
    }

    Profile::create([
        'user_id'    => $userId,
        'name'       => $request->input('name'),
        'image'      => $imagePath,
        'post_code'  => $request->input('post_code'),
        'address'    => $request->input('address'),
        'building'   => $request->input('building'),
    ]);

    return redirect('/');
    }
}
