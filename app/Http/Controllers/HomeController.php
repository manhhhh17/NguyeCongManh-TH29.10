<?php
namespace App\Http\Controllers;
use App\Models\Product;use App\Models\Category;use App\Models\Review;
class HomeController extends Controller {
 public function index(){ $products=Product::with('category')->where('is_active',true)->latest()->take(8)->get();$categories=Category::withCount('products')->orderBy('name')->get();$reviews=Review::with('user')->where('review_type','store')->latest()->take(3)->get();return view('home',compact('products','categories','reviews')); }
 public function store(){ $reviews=Review::with('user')->where('review_type','store')->latest()->paginate(8);$average=Review::where('review_type','store')->avg('rating')??0;return view('store',compact('reviews','average')); }
}
