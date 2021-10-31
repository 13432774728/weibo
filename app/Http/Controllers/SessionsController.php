<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class SessionsController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth', [
    'except' => ['show', 'create', 'store']
    ]);
    
    $this->middleware('guest', [
    'only' => ['create']
    ]);
    }
public function create()
{
return view('sessions.create');
}
public function store(Request $request)
{
$credentials = $this->validate($request, [
'email' => 'required|email|max:255',
'password' => 'required'
]);

if (Auth::attempt($credentials)) {
    //登录成功后的相关操作
    session()->flash('success', '欢迎回来！');
    $fallback = route('users.show', Auth::user());
    return redirect()->intended($fallback);
    } else {
    //登录失败后的相关操作
    session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
    return redirect()->back()->withInput();
    }
    }
public function destroy()
{
Auth::logout();
session()->flash('success', '您已成功退出！');
return redirect('login');
}
}
