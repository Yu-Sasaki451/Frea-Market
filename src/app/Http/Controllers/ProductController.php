<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;

class ProductController extends Controller
{
    public function index(Request $request){
    $query = Product::query();

    if (Auth::check()) {
        $query->where('user_id', '!=', Auth::id());
    }
    $products = $query->get();

    $likedProducts = Auth::check()
        ? Auth::user()->likedProducts()->get(): [];

    return view('index', compact('products','likedProducts'));
    }




    public function productDetail($id){

        $product = Product::with(['condition','categories'])
            ->withCount(['likes','comments'])
            ->findOrFail($id);

        $liked = Auth::check()
        ? $product->likes()->where('users.id', Auth::id())->exists()
        : false;

        return view('detail',compact('product','liked'));
    }

    public function toggleLike($id){

        $user = Auth::user();
        $product = Product::findOrFail($id);

        $alreadyLiked = $user->likedProducts()
            ->where('products.id',$product->id)
            ->exists();

        if ($alreadyLiked) {
            $user->likedProducts()->detach($product->id);
        }
        else {
            $user->likedProducts()->attach($product->id);
        }

        return redirect("/item/{$product->id}");
    }
}
