<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;

class PurchaseController extends Controller
{
    public function showPurchase($id){

    $product = Product::find($id);
    $profile = auth()->user()->profile;
    return view('purchase', compact('product','profile'));
    }

    public function storePurchase(Request $request,$id){
        $user = auth()->id();
        $product = Product::findOrFail($id);

        $purchase_data = new Purchase;
        $purchase_data->user_id = $user;
        $purchase_data->product_id = $product->id;
        $purchase_data->name = $request->input('name');
        $purchase_data->price = $request->input('price');
        $purchase_data->payment = $request->input('payment');
        $purchase_data->address = $request->input('address');
        $purchase_data->building = $request->input('building');
        $purchase_data->save();

        return redirect('/');
    }
}
