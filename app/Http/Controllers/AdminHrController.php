<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberPosition;
use App\Models\MemberProject;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        return view('admin_frontend.hr');
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
}
