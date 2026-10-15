<?php
namespace App\Http\Controllers;
use App\Models\Review;use App\Models\Order;use Illuminate\Http\Request;
class ReviewController extends Controller {
 public function store(Request $r){
  $d=$r->validate(['review_type'=>'required|in:store,product','product_id'=>'nullable|exists:products,id','order_id'=>'nullable|exists:orders,id','rating'=>'required|integer|min:1|max:5','comment'=>'required|string|max:2000']);
  if($d['review_type']==='product'&&empty($d['product_id']))return back()->withErrors(['review'=>'Vui lòng chọn sản phẩm cần đánh giá.']);
  if(!empty($d['order_id'])&&!Order::where('id',$d['order_id'])->where('user_id',$r->user()->id)->exists())abort(403);
  Review::create(['user_id'=>$r->user()->id,'product_id'=>$d['review_type']==='product'?$d['product_id']:null,'order_id'=>$d['order_id']??null,'review_type'=>$d['review_type'],'rating'=>$d['rating'],'comment'=>$d['comment']]);return back()->with('success','Cảm ơn bạn đã đánh giá!');
 }
}
