<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPmController extends Controller
{
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::all()->toArray();
        return view('admin_frontend.pm',compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $member = Member::all()->toArray();
        return view('admin_frontend.pm_create',compact('member'));
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

        return redirect('/PHMS_admin/pm');
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
        return view('admin_frontend.pm_show',compact('projectToShow','project_member'));
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
        return view('admin_frontend.pm_edit',compact('projectToEdit','member','member_is_checked'));
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

        return redirect('/PHMS_admin/pm');
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
        dd($id);
    }

    public function result($id){
        dd($id);
    }
}
