<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request){

        $products = Product::all();

        return view ('index',compact('products'));
    }

    public function showSell(){
        return view('sell');
    }
}
