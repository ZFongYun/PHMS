<?php

namespace App\Http\Controllers;

use App\Imports\MembersImport;
use App\Models\Member;
use App\Models\MemberPosition;
use App\Models\MemberProject;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AdminHrController extends Controller
{
    protected $member;
    protected $member_position;

    public function __construct(Member $member, MemberPosition $member_position)
    {
        $this->member = $member;
        $this->member_position = $member_position;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = Member::all()->toArray(); //取得全部member
        $position = array(); //儲存所有member的職務
        foreach ($member as $item){
            $position_string = ""; //暫存職務內容
            $members = $this->member->find($item['id'])->position->toArray(); //使用關聯找尋於與member.id相符合的資料
            if (empty($members)){
                $position_string = "無職務";
                array_push($position,$position_string);
            }else{
                $member_position_length = count($members);
                for($i=0; $i < $member_position_length; $i++){
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
                array_push($position,$position_string);
            }
        }
        return view('admin_frontend.hr',compact('member','position'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project = Project::all()->toArray();
        return view('admin_frontend.hr_single_create',compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $student_id = $request->input('student_id');
        $email = $request->input('email');
        $join_year = $request->input('join_year');
        $title = $request->input('title');
        $position = $request->input('position');
        $position_mu = $request-> input('position_mu');
        $skill = $request->input('skill');
        $project = $request->input('project');
        $password = $request->input('password');
        $remark = $request->input('remark');

        $hrToStore = $this->member;
        $hrToStore -> student_ID = $student_id;
        $hrToStore -> name = $name;
        $hrToStore -> password = HASH::make($password);
        $hrToStore -> email = $email;
        $hrToStore -> join_year = $join_year;
        $hrToStore -> title = $title;
        $hrToStore -> skill = $skill;
        $hrToStore -> remark = $remark;
        $hrToStore -> save();

        $member_id = $this->member->where('student_ID','=',$student_id)->value('id');

        $hrPositionToStore = $this->member_position;
        $hrPositionToStore -> member_id = $member_id;
        $hrPositionToStore -> position = $position;
        $hrPositionToStore -> save();

        if ($position_mu != null){
            foreach ($position_mu as $row)
            {
                $MemberPosition = new MemberPosition();
                $MemberPosition -> member_id = $member_id;
                $MemberPosition -> position = $row;
                $MemberPosition -> save();
            }
        }

        if ($project != null){
            $project_length = count($project);
            for($i=0; $i<$project_length; $i++){
                $MemberProject = new MemberProject();
                $MemberProject -> member_id = $member_id;
                $MemberProject -> project_id = $project[$i];
                $MemberProject -> save();
            }
        }

        return redirect('/PHMS_admin/hr');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $memberToShow = $this->member->find($id);

        $position_string = ""; //暫存職務內容
            $members = $this->member->find($id)->position->toArray(); //使用關聯找尋於與member.id相符合的資料
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
            ->where('member_id',$id)->whereNull('member_project.deleted_at')
            ->join('project','member_project.project_id','=','project.id')
            ->select('project.id','project.name')
            ->get()->toArray();

        return view('admin_frontend.hr_show',compact('memberToShow','position_string','member_project'));
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
        $member_position = MemberPosition::where('member_id',$id)->get()->toArray();
        $project = Project::all()->toArray();
        $project_is_chk = DB::table('member_project')
            ->where('member_id',$id)->whereNull('member_project.deleted_at')
            ->join('project','member_project.project_id','=','project.id')
            ->select('project.id')
            ->get()->toArray();
        return view('admin_frontend.hr_edit',compact('memberToEdit','member_position','project','project_is_chk'));
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
        $position = $request->input('position');
        $position_mu = $request-> input('position_mu');
        $skill = $request->input('skill');
        $project = $request->input('project');
        $remark = $request->input('remark');
        $password = Member::where('id',$id)->value('password');

        $hrToUpdate = $this->member->find($id);
        $hrToUpdate -> student_ID = $student_id;
        $hrToUpdate -> name = $name;
        $hrToUpdate -> email = $email;
        $hrToUpdate -> join_year = $join_year;
        $hrToUpdate -> title = $title;
        $hrToUpdate -> skill = $skill;
        $hrToUpdate -> remark = $remark;
        $hrToUpdate -> password = $password;
        $hrToUpdate -> save();

        $positionToDelete = MemberPosition::where('member_id',$id)->delete(); //把舊有資料刪除

        $hrPositionToUpdate = $this->member_position;
        $hrPositionToUpdate -> member_id = $id;
        $hrPositionToUpdate -> position = $position;
        $hrPositionToUpdate -> save(); //儲存固定的職務

        if ($position_mu != null){
            foreach ($position_mu as $row)
            {
                $MemberPosition = new MemberPosition();
                $MemberPosition -> member_id = $id;
                $MemberPosition -> position = $row;
                $MemberPosition -> save(); //儲存其他的職務
            }
        }

        $projectToDelete = MemberProject::where('member_id',$id)->delete(); //把舊有資料刪除

        if ($project != null){
            foreach ($project as $row){
                $MemberProject = new MemberProject();
                $MemberProject -> member_id = $id;
                $MemberProject -> project_id = $row;
                $MemberProject -> save();
            }
        }

        return redirect('/PHMS_admin/hr');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $memberToDestroy = $this->member->find($id);
        $memberToDestroy -> delete();
        return redirect('/PHMS_admin/hr');
    }

    public function multiple_create(){
        return view('admin_frontend.hr_multiple_create');
    }

    public function multiple_store(Request $request){
        $request->validate([
            'import_file' => 'required'
        ]);
        Excel::import(new MembersImport, request()->file('import_file'));

        return back()->with('success', '加入成功！');
    }

    public function download(){
        $file = public_path().'/storage/PHMS_import_sample.xlsx';
        return response()->download($file);
    }

    public function reset_edit($id){
        $memberToReset = $this->member->find($id);
        return view('admin_frontend.hr_reset',compact('memberToReset'));
    }

    public function reset_update(Request $request,$id){
        $password = $request->input('password');
        $password_check = $request->input('password_check');

        if ($password != $password_check){
            return back()->with('warning','密碼不一致，請重新輸入。');
        }else{
            $member = Member::where('id',$id)->get()->toArray();
            $name = $member[0]['name'];
            $student_id = $member[0]['student_ID'];
            $email = $member[0]['email'];
            $join_year = $member[0]['join_year'];
            $title = $member[0]['title'];
            $skill = $member[0]['skill'];
            $remark = $member[0]['remark'];

            $memberToResetUpdate = $this->member->find($id);
            $memberToResetUpdate -> student_ID = $student_id;
            $memberToResetUpdate -> name = $name;
            $memberToResetUpdate -> email = $email;
            $memberToResetUpdate -> join_year = $join_year;
            $memberToResetUpdate -> title = $title;
            $memberToResetUpdate -> skill = $skill;
            $memberToResetUpdate -> remark = $remark;
            $memberToResetUpdate -> password = Hash::make($password);
            $memberToResetUpdate->save();
            return redirect('/PHMS_admin/hr');
        }
    }

    public function search(Request $request){
        $target = $request->input('target');
        $keyword = $request->input('keyword');
        $keyword_title = $request->input('keyword_title');
        $keyword_position = $request->input('keyword_position');
        $allResult = array();

        if ($target == 0){
            $members = Member::where('join_year',$keyword)->get();
        }elseif ($target == 1){
            $members = Member::where('name','like','%'.$keyword.'%')->get();
        }elseif ($target == 2){
            $members = Member::where('title',$keyword_title)->get();
        }elseif ($target == 3){
            $member_id = MemberPosition::where('position',$keyword_position)->get();
            $members = array();
            foreach ($member_id as $item){
                $member = Member::where('id',$item['member_id'])->get();
                foreach ($member as $item) {
                    array_push($members,$item);
                }
            }
        }

        //====開始整理成員的職務====
        $position = array();
        foreach ($members as $item) {
            $position_string = ""; //暫存職務內容
            $members_position = $this->member->find($item['id'])->position->toArray(); //使用關聯找尋於與member.id相符合的資料
            if (empty($members_position)) {
                $position_string = "無職務";
                array_push($position, $position_string);
            } else {
                $member_position_length = count($members_position);
                for ($i = 0; $i < $member_position_length; $i++) {
                    if ($members_position[$i]['position'] == 0) {
                        $position_string = $position_string . " PM";
                    } elseif ($members_position[$i]['position'] == 1) {
                        $position_string = $position_string . " HR";
                    } elseif ($members_position[$i]['position'] == 2) {
                        $position_string = $position_string . " 核銷";
                    } elseif ($members_position[$i]['position'] == 3) {
                        $position_string = $position_string . " 行政";
                    } elseif ($members_position[$i]['position'] == 4) {
                        $position_string = $position_string . " 企劃講師";
                    } elseif ($members_position[$i]['position'] == 5) {
                        $position_string = $position_string . " 程式講師";
                    } elseif ($members_position[$i]['position'] == 6) {
                        $position_string = $position_string . " 美術講師";
                    } elseif ($members_position[$i]['position'] == 7) {
                        $position_string = $position_string . " 企劃助教";
                    } elseif ($members_position[$i]['position'] == 8) {
                        $position_string = $position_string . " 程式助教";
                    } elseif ($members_position[$i]['position'] == 9) {
                        $position_string = $position_string . " 美術助教";
                    } elseif ($members_position[$i]['position'] == 10) {
                        $position_string = $position_string . " 無職務";
                    }
                }
                array_push($position, $position_string);
            }
        }
        //====結束整理成員的職務====

        array_push($allResult,$members,$position);

        return $allResult;
//        return $members.$position;
    }
}
