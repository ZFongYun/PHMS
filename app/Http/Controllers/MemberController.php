<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index(){
        return view('member_frontend.index');
    }

    public function login_form(){
        if (Auth::guard('member')->check()){
            return redirect('/PHMS_member');
        }else{
            return view('member_frontend.login');
        }
    }

    public function authenticate(Request $request)
    {
        $validator = Validator($request->all(),[
            'student_id' => 'required',
            'password' => 'required'
        ]);

        if($validator->passes()){

            $student_id = $request -> get('student_id');
            $password = $request -> get('password');

            if (Auth::guard('member')->attempt(['student_ID' => $student_id, 'password' => $password])) { //欄位password > 暗碼；文字框$password > 明碼
                //登入成功...
                return redirect('/PHMS_member');
            }else{
                //登入失敗
                return back()->with('error','帳號或密碼錯誤，請再次確認');
            }
        }else{
            return back()->with('warning','此欄位必填');
        }
    }

    public function logout(){
        Auth::guard('member')->logout();
        return redirect('/PHMS_member/login');
    }

    public function signup_form(){
        return view('member_frontend.signup');
    }

    public function register(Request $request){

    }
}
