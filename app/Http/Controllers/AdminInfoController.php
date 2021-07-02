<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminInfoController extends Controller
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_id = auth('admin')->user()->id;
        $adminToIndex = $this->admin->find($admin_id);
        return view('admin_frontend.userinfo',compact('adminToIndex'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adminToEdit = $this->admin->find($id);
        return view('admin_frontend.userinfo_edit',compact('adminToEdit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $account = $request->input('account');
        $adminToUpdate = $this->admin->find($id);
        $adminToUpdate->account=$account;
        $adminToUpdate -> save();
        return redirect('/PHMS_admin/userinfo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reset_edit($id){
        $adminToReset = $this->admin->find($id);
        return view('admin_frontend.userinfo_reset',compact('adminToReset'));
    }

    public function reset_update(Request $request, $id){
        $password = $request->input('password');
        $password_check = $request->input('password_check');

        if ($password != $password_check){
            return back()->with('warning','密碼不一致，請重新輸入。');
        }else{
            $adminToUpdate = $this->admin->find($id);
            $adminToUpdate->password = Hash::make($password);
            $adminToUpdate->save();
            return redirect('/PHMS_admin/userinfo');
        }
    }
}
