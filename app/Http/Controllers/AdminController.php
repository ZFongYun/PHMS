<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
//        return view('admin_frontend.index');
        if (Auth::guard('admin')->check()){
//            return redirect('/PHMS_admin');
            return view('admin_frontend.index');
        }
        return view('admin_frontend.login');
    }

    public function login(Request $request)
    {
        $validator = Validator($request->all(),[
            'account' => 'required',
            'password' => 'required'
        ]);

        if($validator->passes()){

            $account = $request -> get('account');
            $password = $request -> get('password');

            if (Auth::guard('admin')->attempt(['account' => $account, 'password' => $password])) { //欄位password > 暗碼；文字框$password > 明碼
                //登入成功...
                return redirect('/PHMS_admin');
            }else{
                //登入失敗
                return back()->with('error','帳號或密碼錯誤，請再次確認');
            }
        }else{
            return back()->with('warning','此欄位必填');
        }
    }

    public  function  logout(){
        Auth::guard('admin')->logout();
        return redirect('/PHMS_admin/AdminLogin');
    }
}
