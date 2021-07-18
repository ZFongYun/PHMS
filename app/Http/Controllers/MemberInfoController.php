<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberProject;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function index()
    {
        $member_id = auth('member')->user()->id;
        $memberToIndex = $this->member->find($member_id);
        $position_string = ""; //暫存職務內容
        $members = $this->member->find($member_id)->position->toArray(); //使用關聯找尋於與member.id相符合的資料
        if (empty($members)){
            $position_string = "無職務";
        }else{

            for($i=0; $i < count($members); $i++){
                if ($members[$i]['position'] == 0){
                    $position_string = $position_string." PM";
                }elseif ($members[$i]['position'] == 1){
                    $position_string = $position_string." HR";
                }elseif ($members[$i]['position'] == 2){
                    $position_string = $position_string." 核銷";
                }elseif ($members[$i]['position'] == 3){
                    $position_string = $position_string." 行政";
                }elseif ($members[$i]['position'] == 4){
                    $position_string = $position_string." 企劃講師";
                }elseif ($members[$i]['position'] == 5){
                    $position_string = $position_string." 程式講師";
                }elseif ($members[$i]['position'] == 6){
                    $position_string = $position_string." 美術講師";
                }elseif ($members[$i]['position'] == 7){
                    $position_string = $position_string." 企劃助教";
                }elseif ($members[$i]['position'] == 8){
                    $position_string = $position_string." 程式助教";
                }elseif ($members[$i]['position'] == 9){
                    $position_string = $position_string." 美術助教";
                }elseif ($members[$i]['position'] == 10){
                    $position_string = $position_string." 無職務";
                }
            }
        }

        $member_project = DB::table('member_project')
            ->where('member_id',$member_id)->whereNull('member_project.deleted_at')
            ->join('project','member_project.project_id','=','project.id')
            ->select('project.id','project.name')
            ->get()->toArray();
        return view('member_frontend.userinfo',compact('memberToIndex','position_string','member_project'));
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
        $memberToEdit = $this->member->find($id);
        $project = Project::all()->toArray();
        $project_is_chk = DB::table('member_project')
            ->where('member_id',$id)->whereNull('member_project.deleted_at')
            ->join('project','member_project.project_id','=','project.id')
            ->select('project.id')
            ->get()->toArray();
        return view('member_frontend.userinfo_edit',compact('memberToEdit','project','project_is_chk'));
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
        $name = $request->input('name');
        $student_id = $request->input('student_id');
        $email = $request->input('email');
        $join_year = $request->input('join_year');
        $title = $request->input('title');
        $skill = $request->input('skill');
        $project = $request->input('project');
        $remark = $request->input('remark');
        $password = Member::where('id',$id)->value('password');

        $memberToUpdate = $this->member->find($id);
        $memberToUpdate -> student_ID = $student_id;
        $memberToUpdate -> name = $name;
        $memberToUpdate -> email = $email;
        $memberToUpdate -> join_year = $join_year;
        $memberToUpdate -> title = $title;
        $memberToUpdate -> skill = $skill;
        $memberToUpdate -> remark = $remark;
        $memberToUpdate -> password = $password;
        $memberToUpdate -> save();

        $projectToDelete = MemberProject::where('member_id',$id)->delete(); //把舊有資料刪除

        if ($project != null){
            foreach ($project as $row){
                $MemberProject = new MemberProject();
                $MemberProject -> member_id = $id;
                $MemberProject -> project_id = $row;
                $MemberProject -> save();
            }
        }

        return redirect('/PHMS_member/userinfo');
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
        $memberToReset = $this->member->find($id);
        return view('member_frontend.userinfo_reset',compact('memberToReset'));
    }

    public function reset_update(Request $request,$id){
        $password = $request->input('password');
        $password_check = $request->input('password_check');

        if ($password != $password_check){
            return back()->with('warning','密碼不一致，請重新輸入。');
        }else{
            $memberToUpdate = $this->member->find($id);
            $memberToUpdate->password = Hash::make($password);
            $memberToUpdate->save();
            return redirect('/PHMS_member/userinfo');
        }
    }
}
