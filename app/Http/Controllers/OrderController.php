<?php
namespace App\Http\Controllers;
use App\Models\Cart;use App\Models\Order;use Illuminate\Http\Request;use Illuminate\Support\Facades\DB;use Illuminate\Support\Str;
class OrderController extends Controller {
 public function checkout(Request $r){$cart=Cart::with('items.variant.product')->firstOrCreate(['user_id'=>$r->user()->id]);if($cart->items->isEmpty())return redirect()->route('cart.index')->withErrors(['cart'=>'Giỏ hàng đang trống.']);$subtotal=$cart->items->sum(fn($i)=>(float)$i->variant->product->price*$i->quantity);return view('orders.checkout',compact('cart','subtotal'));}
 public function place(Request $r){
  $d=$r->validate(['recipient_name'=>'required|string|max:100','phone'=>'required|string|max:20','shipping_address'=>'required|string|max:255','payment_method'=>'required|in:cod','note'=>'nullable|string|max:1000','voucher'=>'nullable|string|max:40']);
  $cart=Cart::with('items.variant.product')->firstOrCreate(['user_id'=>$r->user()->id]);if($cart->items->isEmpty())return redirect()->route('cart.index')->withErrors(['cart'=>'Giỏ hàng đang trống.']);
  return DB::transaction(function()use($cart,$d,$r){
   $subtotal=0;foreach($cart->items as $item){$v=$item->variant()->lockForUpdate()->firstOrFail();if($v->stock<$item->quantity||!$v->product->is_active)return back()->withErrors(['cart'=>'Sản phẩm hết hàng hoặc không đủ số lượng.']);$subtotal+=(float)$v->product->price*$item->quantity;}
   $discount=strtoupper(trim($d['voucher']??''))==='WELCOME10'?round($subtotal*.1,2):0;$shipping=$subtotal>=500000?0:30000;
   $o=Order::create(['user_id'=>$r->user()->id,'order_code'=>'MF'.now()->format('ymd').strtoupper(Str::random(6)),'recipient_name'=>$d['recipient_name'],'phone'=>$d['phone'],'shipping_address'=>$d['shipping_address'],'subtotal'=>$subtotal,'discount_amount'=>$discount,'shipping_fee'=>$shipping,'total_amount'=>max(0,$subtotal-$discount+$shipping),'payment_method'=>'cod','payment_status'=>'unpaid','status'=>'pending','note'=>$d['note']??null]);
   foreach($cart->items as $item){$v=$item->variant()->lockForUpdate()->firstOrFail();$p=$v->product;$o->items()->create(['product_id'=>$p->id,'variant_id'=>$v->id,'product_name'=>$p->name,'size'=>$v->size,'color'=>$v->color,'unit_price'=>$p->price,'quantity'=>$item->quantity,'line_total'=>(float)$p->price*$item->quantity]);$v->decrement('stock',$item->quantity);}
   $cart->items()->delete();return redirect()->route('orders.show',$o)->with('success','Đặt hàng thành công. Thanh toán COD khi nhận hàng.');
  });
 }
 public function index(Request $r){$orders=Order::with('items')->where('user_id',$r->user()->id)->latest()->paginate(10);return view('orders.index',compact('orders'));}
 public function show(Request $r,Order $order){abort_unless($order->user_id===$r->user()->id||$r->user()->role==='admin',403);$order->load('items');return view('orders.show',compact('order'));}
}
