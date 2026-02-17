<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Condition;
use App\Http\Requests\ExhibitionRequest;

class SellController extends Controller
{
    public function showSell(){
        $categories = Category::all();
        $conditions = Condition::all();
        return view('sell',compact('categories','conditions'));
    }

    public function storeProduct(ExhibitionRequest $request){

        $user = auth()->id();

        $product_data = new Product;
        $product_data->user_id = $user;
        $product_data->condition_id = $request->input('condition_id');
        $product_data->name = $request->input('name');

        if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $product_data->image = $path;}

        $product_data->brand = $request->input('brand');
        $product_data->price = $request->input('price');
        $product_data->description = $request->input('description');
        $product_data->save();

        $categoryIds = $request->input('categories', []);
        $product_data->categories()->sync($categoryIds);

        return redirect('/');
    }
}
