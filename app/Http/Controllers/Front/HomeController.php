<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
   public function index()
   {
    
    $products = Product::with('category')->active()
    //->latest()
    ->limit(8)
    ->get();
        return view('front.home', compact('products'));
    }
}
