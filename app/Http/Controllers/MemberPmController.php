<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberPmController extends Controller
{
    protected $member;
    protected $project;

    public function __construct(Member $member, Project $project)
    {
        $this->member = $member;
        $this->project = $project;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member_id = auth('member')->user()->id;
        $member_title = $this->member->where('id',$member_id)->pluck('title');

        $projectToIndex = DB::table('project_member')
            ->where('member_id',$member_id)->whereNull('project_member.deleted_at')
            ->join('project','project_member.project_id','=','project.id')
            ->select('project.*')
            ->orderByRaw('id asc')
            ->get()->toArray();

        if ($member_title[0] == 2){
            return view('member_frontend.pm_specific',compact('projectToIndex'));
        }else{
            return view('member_frontend.pm',compact('projectToIndex'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $member = Member::all()->toArray();
        return view('member_frontend.pm_create',compact('member'));
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
        $content = $request->input('content');
        $school_year = $request->input('school_year');
        $semester = $request->input('semester');
        $project_start = $request->input('project_start');
        $project_end = $request->input('project_end');
        $status = $request->input('status');
        $member = $request->input('memberId');

        $pmToStore = $this->project;
        $pmToStore -> name = $name;
        $pmToStore -> content = $content;
        $pmToStore -> school_year = $school_year;
        $pmToStore -> semester = $semester;
        $pmToStore -> start_date = $project_start;
        $pmToStore -> end_date = $project_end;
        $pmToStore -> status = $status;
        $pmToStore -> save();

        $cut_id = explode(",",$member);
        $project_id = $this->project->where('name','=',$name)->value('id');
        if ($cut_id != null){
            foreach ($cut_id as $row)
            {
                $ProjectMember = new ProjectMember();
                $ProjectMember -> project_id = $project_id;
                $ProjectMember -> member_id = $row;
                $ProjectMember -> save();
            }
        }

        return redirect('/PHMS_member/pm');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projectToShow = $this->project->find($id);
        $project_member = DB::table('project_member')
            ->where('project_id',$id)->whereNull('project_member.deleted_at')
            ->join('member','project_member.member_id','=','member.id')
            ->select('member.name','member.title')
            ->get()->toArray();
        return view('member_frontend.pm_show',compact('projectToShow','project_member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projectToEdit = $this->project->find($id);
        $member = Member::all()->toArray();
        $member_is_checked = DB::table('project_member')
            ->where('project_id',$id)->whereNull('project_member.deleted_at')
            ->join('member','project_member.member_id','=','member.id')
            ->select('member.id')
            ->get()->toArray();
        return view('member_frontend.pm_edit',compact('projectToEdit','member','member_is_checked'));
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
        $content = $request->input('content');
        $school_year = $request->input('school_year');
        $semester = $request->input('semester');
        $project_start = $request->input('project_start');
        $project_end = $request->input('project_end');
        $status = $request->input('status');
        $member = $request->input('memberId');

        $pmToStore = $this->project->find($id);
        $pmToStore -> name = $name;
        $pmToStore -> content = $content;
        $pmToStore -> school_year = $school_year;
        $pmToStore -> semester = $semester;
        $pmToStore -> start_date = $project_start;
        $pmToStore -> end_date = $project_end;
        $pmToStore -> status = $status;
        $pmToStore -> save();

        $memberToDelete = ProjectMember::where('project_id',$id)->delete(); //把舊有的參與成員刪除

        $cut_id = explode(",",$member);
        if ($cut_id != null){
            foreach ($cut_id as $row)
            {
                $ProjectMember = new ProjectMember();
                $ProjectMember -> project_id = $id;
                $ProjectMember -> member_id = $row;
                $ProjectMember -> save();
            }
        }

        return redirect('/PHMS_member/pm');
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

    public function schdlm($id){
        return view('member_frontend.schdlm',compact('id'));
    }

    public function schdlm_create($id){
        return view('member_frontend.schdlm_create',compact('id'));
    }

    public function schdlm_store(Request $request, $id){
        dd($id);
    }

    public function result($id){
        dd($id);
    }
}
