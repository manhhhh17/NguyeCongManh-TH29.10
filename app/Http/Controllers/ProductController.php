<?php
namespace App\Http\Controllers;
use App\Models\Product;use App\Models\Category;use Illuminate\Http\Request;
class ProductController extends Controller {
 public function index(Request $r){
  $q=Product::with(['category','variants'])->where('is_active',true);
  if($r->filled('q')){$term=trim($r->q);$q->where(fn($s)=>$s->where('name','like',"%{$term}%")->orWhere('description','like',"%{$term}%"));}
  if($r->filled('category'))$q->where('category_id',$r->integer('category'));
  if($r->sort==='price_asc')$q->orderBy('price');elseif($r->sort==='price_desc')$q->orderByDesc('price');else $q->latest();
  $products=$q->paginate(12)->withQueryString();$categories=Category::orderBy('name')->get();return view('products.index',compact('products','categories'));
 }
 public function show(Product $product){abort_unless($product->is_active,404);$product->load(['category','variants']);$reviews=$product->reviews()->with('user')->where('review_type','product')->latest()->paginate(5);$average=$product->reviews()->where('review_type','product')->avg('rating')??0;return view('products.show',compact('product','reviews','average'));}
}
