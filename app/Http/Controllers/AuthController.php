<?php
namespace App\Http\Controllers;
use App\Models\User; use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth; use Illuminate\Support\Facades\Hash; use Illuminate\Validation\Rules\Password;
class AuthController extends Controller {
 public function showRegister(){return view('auth.register');}
 public function showLogin(){return view('auth.login');}
 public function register(Request $r){
  $d=$r->validate(['name'=>'required|string|max:100','email'=>'required|email|max:150|unique:users,email','phone'=>'nullable|string|max:20','password'=>['required','confirmed',Password::min(8)]]);
  $u=User::create(['name'=>$d['name'],'email'=>$d['email'],'phone'=>$d['phone']??null,'password'=>Hash::make($d['password']),'role'=>'customer']);
  Auth::login($u);$r->session()->regenerate();return redirect()->route('home')->with('success','Tạo tài khoản thành công!');
 }
 public function login(Request $r){
  $d=$r->validate(['email'=>'required|email','password'=>'required|string']);
  if(!Auth::attempt($d,$r->boolean('remember')))return back()->withErrors(['email'=>'Email hoặc mật khẩu chưa đúng.'])->onlyInput('email');
  $r->session()->regenerate();return redirect()->intended(route('home'))->with('success','Đăng nhập thành công!');
 }
 public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect()->route('home')->with('success','Bạn đã đăng xuất.');}
}
