<?php
namespace App\Http\Controllers;
use App\Models\Contact;use Illuminate\Http\Request;
class ContactController extends Controller {
 public function create(){return view('contact');}
 public function store(Request $r){$d=$r->validate(['name'=>'required|string|max:100','email'=>'required|email|max:150','phone'=>'nullable|string|max:20','subject'=>'required|string|max:150','message'=>'required|string|max:3000']);Contact::create($d+['status'=>'new']);return back()->with('success','Đã ghi nhận liên hệ.');}
}
