<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function showPurchase($id){

        $product = Purchase::with('product')->find($id);

        return view('purchase',compact('product'));
    }
}
