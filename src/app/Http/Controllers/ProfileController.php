<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Product;
use App\Models\Purchase;

class ProfileController extends Controller
{
    public function showMypage(){
        //ログインユーザーに紐づくプロフィールを1件取得
        $profile = Profile::where('user_id',Auth::id())->first();

         //ログインユーザーの出品商品
        $products = Product::where('user_id', Auth::id())->get();

        //ログインユーザーの購入商品（商品情報も一緒に取得）
        $purchases = Purchase::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('profile.mypage',compact('profile','products','purchases'));
    }

    public function mypageEdit(){
        //ログインユーザーに紐づくプロフィールを1件取得
        $profile = Profile::where('user_id',Auth::id())->first();

        return view('profile.mypage_edit',compact('profile'));
    }

    public function saveProfile(Request $request){
        //ログインユーザーのID取得
        $userId = auth()->id();

        //リクエストから取得
        $data = [
            'name'       => $request->input('name'),
            'post_code'  => $request->input('post_code'),
            'address'    => $request->input('address'),
            'building'   => $request->input('building'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('profiles', 'public');
        }

        //プロフィール作成・編集
        Profile::updateOrCreate(
            ['user_id' => $userId],
            $data
        );


    return redirect('/');
    }
}
