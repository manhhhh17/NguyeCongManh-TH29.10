<?php
namespace App\Http\Controllers;
use App\Models\Cart;use App\Models\CartItem;use App\Models\ProductVariant;use Illuminate\Http\Request;
class CartController extends Controller {
 private function getCart($user):Cart{return Cart::firstOrCreate(['user_id'=>$user->id]);}
 public function index(Request $r){$cart=$this->getCart($r->user())->load('items.variant.product');$subtotal=$cart->items->sum(fn($i)=>(float)$i->variant->product->price*$i->quantity);return view('cart.index',compact('cart','subtotal'));}
 public function store(Request $r){
  $d=$r->validate(['variant_id'=>'required|exists:product_variants,id','quantity'=>'required|integer|min:1|max:20']);$v=ProductVariant::with('product')->findOrFail($d['variant_id']);
  if(!$v->product->is_active||$v->stock<$d['quantity'])return back()->withErrors(['cart'=>'Sản phẩm không đủ tồn kho.']);
  $cart=$this->getCart($r->user());$item=$cart->items()->where('variant_id',$v->id)->first();$qty=($item?->quantity??0)+$d['quantity'];
  if($qty>$v->stock)return back()->withErrors(['cart'=>'Số lượng vượt tồn kho.']);if($item)$item->update(['quantity'=>$qty]);else $cart->items()->create(['variant_id'=>$v->id,'quantity'=>$d['quantity']]);
  return redirect()->route('cart.index')->with('success','Đã thêm sản phẩm vào giỏ hàng.');
 }
 public function update(Request $r,CartItem $item){abort_unless($item->cart->user_id===$r->user()->id,403);$d=$r->validate(['quantity'=>'required|integer|min:1|max:20']);if($d['quantity']>$item->variant->stock)return back()->withErrors(['cart'=>'Số lượng vượt tồn kho.']);$item->update($d);return back()->with('success','Đã cập nhật giỏ hàng.');}
 public function destroy(Request $r,CartItem $item){abort_unless($item->cart->user_id===$r->user()->id,403);$item->delete();return back()->with('success','Đã xóa sản phẩm.');}
}
