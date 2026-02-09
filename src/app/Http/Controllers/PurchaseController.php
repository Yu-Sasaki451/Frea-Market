<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Comment;

class PurchaseController extends Controller
{
    public function showPurchase($id){

    $product = Product::find($id);
    $profile = auth()->user()->profile;

    $sessionAddress = session('purchase_address');
    $hasSessionAddress = is_array($sessionAddress);

    $shipping = [
        'post_code' => $hasSessionAddress && array_key_exists('post_code', $sessionAddress)
            ? $sessionAddress['post_code']
            : $profile->post_code,
        'address'   => $hasSessionAddress && array_key_exists('address', $sessionAddress)
            ? $sessionAddress['address']
            : $profile->address,
        'building'  => $hasSessionAddress && array_key_exists('building', $sessionAddress)
            ? $sessionAddress['building']
            : $profile->building,
    ];

    return view('purchase', compact('product','profile','shipping'));
    }

    public function showPurchaseAddress($id){

        $product = Product::find($id);
        return view('purchase_address',compact('product'));
    }

    public function storePurchaseAddress(Request $request,$id){

        $data = $request->only(['post_code','address','building']);
        $data = array_map(fn($v) => $v === '' ? null : $v, $data);
        $request->session()->put('purchase_address',$data);

        return redirect ('/purchase/' .$id);
    }

    public function storePurchase(Request $request,$id){
        $user = auth()->id();
        $product = Product::findOrFail($id);

        $purchase_data = new Purchase;
        $purchase_data->user_id = $user;
        $purchase_data->product_id = $product->id;
        $purchase_data->name = $request->input('name');
        $purchase_data->price = $request->input('price');
        $purchase_data->post_code = $request->input('post_code');
        $purchase_data->payment = $request->input('payment');
        $purchase_data->address = $request->input('address');
        $purchase_data->building = $request->input('building');
        $purchase_data->save();

        $request->session()->forget('purchase_address');

        return redirect('/');
    }

    public function storeComment(Request $request,$id){
        $user = auth()->id();
        $product = Product::findOrFail($id);

        $product_comment = new Comment;
        $product_comment->user_id = $user;
        $product_comment->product_id = $product->id;
        $product_comment->content = $request->input('content');
        $product_comment->save();

        return redirect("/item/{$product->id}");

    }
}
