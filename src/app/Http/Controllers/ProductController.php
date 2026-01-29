<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;

class ProductController extends Controller
{
    public function index(Request $request){

        $products = Product::all();

        return view ('index',compact('products'));
    }

    public function showSell(){
        return view('sell');
    }

    public function productDetail($id){

        $product = Product::with('condition','categories','comments')->find($id);

        return view('detail',compact('product'));
    }
}
