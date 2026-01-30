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
}
