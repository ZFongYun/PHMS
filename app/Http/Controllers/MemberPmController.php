<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectMember;
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
        dd($id);
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

    public function schdlm($id){
        dd($id);
    }

    public function result($id){
        dd($id);
    }
}
