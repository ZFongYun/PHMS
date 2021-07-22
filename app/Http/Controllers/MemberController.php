<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    protected $member;
    protected $member_position;

    public function __construct(Member $member, MemberPosition $member_position)
    {
        $this->member = $member;
        $this->member_position = $member_position;
    }

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
        if (Auth::guard('member')->check()){
            return redirect('/PHMS_member');
        }else{
            return view('member_frontend.signup');
        }
    }

    public function register(Request $request){
        $validator = Validator($request->all(),[  //認證
            'name' => 'required',
            'student_id' => 'required',
            'join_year' => 'required',
            'title' => 'required',
            'password' => 'required'
        ]);

        if($validator->passes()){
            //認證通過...

            $name = $request->input('name');
            $student_id = $request->input('student_id');
            $join_year = $request->input('join_year');
            $title = $request->input('title');
            $password = $request->input('password');

            $member_check = $this->member->where('student_ID',$student_id)->get()->toArray();
            //判斷此學號是否已存在

            if ($member_check == null){
                $memberToRegister = $this->member;
                $memberToRegister->name = $name;
                $memberToRegister->student_ID = $student_id;
                $memberToRegister->join_year = $join_year;
                $memberToRegister->title = $title;
                $memberToRegister->password = HASH::make($password);
                $memberToRegister->save();

                $member_id = $this->member->where('student_ID','=',$student_id)->value('id'); //取得id
                $positionToRegister = $this->member_position;
                $positionToRegister -> member_id = $member_id;
                $positionToRegister -> position = '10';
                $positionToRegister -> save();
                echo "<script>alert('完成註冊。')</script>";
                echo '<meta http-equiv=REFRESH CONTENT=0.5;url=/PHMS_member/login>';
            }else{
                return back()->with('warningAccount','此帳號已存在。');
            }

        }else{
            //認證失敗...
            return back()->with('warning','欄位必填。');
            //返回前一頁面
        }
    }
}
