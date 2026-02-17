<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function showMypage(){
        $profile = Profile::where('user_id',Auth::id())->first();

        $products = Product::where('user_id', Auth::id())->get();

        $purchases = Purchase::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('profile.mypage',compact('profile','products','purchases'));
    }

    public function mypageEdit(){
        $profile = Profile::where('user_id',Auth::id())->first();

        return view('profile.mypage_edit',compact('profile'));
    }

    public function saveProfile(ProfileRequest $request){
        $userId = auth()->id();

        $data = [
            'name'       => $request->input('name'),
            'post_code'  => $request->input('post_code'),
            'address'    => $request->input('address'),
            'building'   => $request->input('building'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('profiles', 'public');
        }

        Profile::updateOrCreate(
            ['user_id' => $userId],
            $data
        );


    return redirect('/');
    }
}
