<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showMypage(){
        //ログインユーザーに紐づくプロフィールを1件取得
        $profile = Profile::where('user_id',Auth::id())->first();

        return view('profile.mypage',compact('profile'));
    }

    public function mypageEdit(){
        //ログインユーザーに紐づくプロフィールを1件取得
        $profile = Profile::where('user_id',Auth::id())->first();

        return view('profile.mypage_edit',compact('profile'));
    }

    public function storeProfile(Request $request){
        //ログインユーザーのID取得
        $userId = auth()->id();

        //画像パスの保存
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profiles', 'public');}

        //プロフィール作成
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
