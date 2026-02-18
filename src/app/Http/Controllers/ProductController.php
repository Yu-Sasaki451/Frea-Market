<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Purchase;

class ProductController extends Controller
{

    public function index(Request $request){

    $query = Product::query();

    $keyword = $request->input('keyword');

    //自分の出品を除外
    if (Auth::check()) {$query->where('user_id', '!=', Auth::id());}

    //いいねしたマイリスト
    $likedProducts = collect();
    if (Auth::check()) {$likedQuery = Auth::user()->likedProducts();
    if (!empty($keyword)) {$likedQuery->where('name', 'like', '%' . $keyword . '%');}
    $likedProducts = $likedQuery->get();}

    //検索フォーム部分一致
    if (!empty($keyword)) {$query->where('name', 'like', '%' . $keyword . '%');}

    $products = $query->get();

    //購入済みかチェック（誰かが購入済みならSold表示）
    $purchasedProducts = Purchase::pluck('product_id')->all();

    return view('index', compact('products','likedProducts','purchasedProducts'));
}



    public function productDetail($id){
        //状態とカテゴリも取得、いいねとコメントをカウント
        $product = Product::with(['condition','categories','comments.user.profile'])
            ->withCount(['likes','comments'])
            ->findOrFail($id);

        //ログイン時だけいいねできる
        $liked = Auth::check()
        ? $product->likes()->where('users.id', Auth::id())->exists()
        : false;

        return view('detail',compact('product','liked'));
    }

    public function toggleLike($id){

        $user = Auth::user();
        $product = Product::findOrFail($id);

        //いいね済みかチェック
        $alreadyLiked = $user->likedProducts()
            ->where('products.id',$product->id)
            ->exists();

        //いいね済みなら解除、してなければいいね登録
        if ($alreadyLiked) {
            $user->likedProducts()->detach($product->id);
        }
        else {
            $user->likedProducts()->attach($product->id);
        }

        return redirect("/item/{$product->id}");
    }
}
