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
        $member = Member::all()->toArray();
        $member_id = Member::all('id')->toArray(); //取得所有member id

        $position = array();
        $position_string = "";

        foreach ($member_id as $id){
            $member_position = MemberPosition::where('member_id',$id)->get()->toArray();
            if (empty($member_position)){
                $position_string = "無職務";
                array_push($position,$position_string);
            }else{
                $member_position_length = count($member_position);
                for($i=0; $i < $member_position_length; $i++){
                    if ($member_position[$i]['position'] == 0){
                        $position_string = $position_string." PM";
                    }elseif ($member_position[$i]['position'] == 1){
                        $position_string = $position_string." HR";
                    }elseif ($member_position[$i]['position'] == 2){
                        $position_string = $position_string." 核銷";
                    }elseif ($member_position[$i]['position'] == 3){
                        $position_string = $position_string." 行政";
                    }elseif ($member_position[$i]['position'] == 4){
                        $position_string = $position_string." 企劃講師";
                    }elseif ($member_position[$i]['position'] == 5){
                        $position_string = $position_string." 程式講師";
                    }elseif ($member_position[$i]['position'] == 6){
                        $position_string = $position_string." 美術講師";
                    }elseif ($member_position[$i]['position'] == 7){
                        $position_string = $position_string." 企劃助教";
                    }elseif ($member_position[$i]['position'] == 8){
                        $position_string = $position_string." 程式助教";
                    }elseif ($member_position[$i]['position'] == 9){
                        $position_string = $position_string." 美術助教";
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

        $position_string = ""; //成員的職務
        $member_position = MemberPosition::where('member_id',$id)->get()->toArray();
        if (empty($member_position)){
            $position_string = "無職務";
        }else{
            $member_position_length = count($member_position);
            for($i=0; $i < $member_position_length; $i++){
                if ($member_position[$i]['position'] == 0){
                    $position_string = $position_string." PM";
                }elseif ($member_position[$i]['position'] == 1){
                    $position_string = $position_string." HR";
                }elseif ($member_position[$i]['position'] == 2){
                    $position_string = $position_string." 核銷";
                }elseif ($member_position[$i]['position'] == 3){
                    $position_string = $position_string." 行政";
                }elseif ($member_position[$i]['position'] == 4){
                    $position_string = $position_string." 企劃講師";
                }elseif ($member_position[$i]['position'] == 5){
                    $position_string = $position_string." 程式講師";
                }elseif ($member_position[$i]['position'] == 6){
                    $position_string = $position_string." 美術講師";
                }elseif ($member_position[$i]['position'] == 7){
                    $position_string = $position_string." 企劃助教";
                }elseif ($member_position[$i]['position'] == 8){
                    $position_string = $position_string." 程式助教";
                }elseif ($member_position[$i]['position'] == 9){
                    $position_string = $position_string." 美術助教";
                }
            }
        }

        $member_project = DB::table('member_project')
            ->where('member_id',$id)
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
        //
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
        //
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
}
