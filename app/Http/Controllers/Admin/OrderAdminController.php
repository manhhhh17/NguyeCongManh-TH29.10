<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;use App\Models\Order;use Illuminate\Http\Request;
class OrderAdminController extends Controller {
 public function index(){$orders=Order::with('user','items')->latest()->paginate(20);return view('admin.orders.index',compact('orders'));}
 public function update(Request $r,Order $order){$d=$r->validate(['status'=>'required|in:pending,confirmed,shipping,delivered,cancelled']);if(in_array($order->status,['cancelled','delivered']))return back()->withErrors(['status'=>'Không thể thay đổi đơn đã hủy hoặc đã giao.']);$order->update($d);if($d['status']==='delivered'&&$order->payment_method==='cod')$order->update(['payment_status'=>'paid']);return back()->with('success','Đã cập nhật trạng thái đơn hàng.');}
}
