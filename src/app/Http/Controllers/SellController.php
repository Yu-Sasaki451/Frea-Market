<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Condition;

class SellController extends Controller
{
    public function showSell(){
        $categories = Category::all();
        $conditions = Condition::all();
        return view('sell',compact('categories','conditions'));
    }
}
