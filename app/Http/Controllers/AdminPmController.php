<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectResult;
use App\Models\ProjectSchdl;
use App\Models\SchdlProjectPa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminPmController extends Controller
{
    protected $project;
    protected $project_schdl;
    protected $project_result;

    public function __construct(Project $project, ProjectSchdl $project_schdl, ProjectResult $project_result)
    {
        $this->project = $project;
        $this->project_schdl = $project_schdl;
        $this->project_result = $project_result;
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
            ->select('member.name','member.title','member.id')
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
        $projectToDestroy = $this->project->find($id);
        $projectToDestroy -> delete();
        return redirect('/PHMS_admin/pm');
    }

    public function destroy_exception($id){
        $projectToDestroy = $this->project->find($id);
        $projectToDestroy -> delete();
        return redirect('/PHMS_admin/pm');
    }

    public function schdlm($id){
        $schdlToIndex = $this->project_schdl->where('project_id',$id)->get();
        $project = $this->project->find($id);
        $project_name = $project['name'];
        return view('admin_frontend.schdlm',compact('id','schdlToIndex','project_name'));
    }

    public function schdlm_download($id,$schdlId){
        $filename = ProjectSchdl::where('id',$schdlId)->value('file_name');

        $dir = '/';
        $recursive = false; //是否取得資料夾下的目錄
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));

        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->sortBy('timestamp')
            ->last(); //在$contents找是否有符合的文件

        $rawData = Storage::cloud()->get($file['path']); //從$file取得路徑名稱

        return response($rawData, 200)
            ->header('ContentType', $file['mimetype'])
            ->header('Content-Disposition', "attachment; filename=$filename"); //下載文件
    }

    public function schdlm_pa($id, $schdlId){
        $schdl = $this->project_schdl->find($schdlId);
        $schdl_name = $schdl['name'];

        $project_pa = SchdlProjectPa::where('project_id',$id)
            ->where('project_schdl_id',$schdlId)->get()->toArray();

        $project_member = DB::table('project_member')
            ->where('project_id',$id)->whereNull('project_member.deleted_at')
            ->join('member','project_member.member_id','=','member.id')
            ->select('member.*')
            ->get()->toArray();

        $member_pa = DB::table('schdl_member_pa')
            ->where('project_schdl_id',$schdlId)
            ->join('member','schdl_member_pa.member_id','=','member.id')
            ->select('member.id','member.student_ID','member.name','member.title','schdl_member_pa.score','schdl_member_pa.explanation')
            ->get()->toArray();

        $project_schdl = $this->project_schdl->where('project_id',$id)->where('id',$schdlId)->get()->toArray();

        return view('admin_frontend.schdlm_pa',compact('schdl_name','id','schdlId','project_member','project_pa','member_pa','project_schdl'));
    }

    public function result($id){
        $is_null = $this->project_result->where('project_id',$id)->get()->toArray();
        $project_name = Project::where('id',$id)->value('name');

        if (empty($is_null)){
            return view('admin_frontend.result_null',compact('id','project_name'));
        }else{
            $resultToIndex = $this->project_result->where('project_id',$id)->get()->toArray();
            $project_member = DB::table('project_member')
                ->where('project_id',$id)->whereNull('project_member.deleted_at')
                ->join('member','project_member.member_id','=','member.id')
                ->select('member.id','member.name','member.title')
                ->get()->toArray();

            $dir = '/';
            $recursive = false; //是否取得資料夾下的目錄
            $contents = collect(Storage::cloud()->listContents($dir, $recursive));
            $video_file = $contents
                ->where('type', '=', 'file')
                ->where('filename', '=', pathinfo($resultToIndex[0]['movie_file_name'], PATHINFO_FILENAME))
                ->where('extension', '=', pathinfo($resultToIndex[0]['movie_file_name'], PATHINFO_EXTENSION))
                ->sortBy('timestamp')
                ->last();
            if (isset($video_file)){
                $video_url = Storage::cloud()->url($video_file['path']);
            }else{
                $video_url = '';
            }
            $exe_file = $contents
                ->where('type', '=', 'file')
                ->where('filename', '=', pathinfo($resultToIndex[0]['executable_file_name'], PATHINFO_FILENAME))
                ->where('extension', '=', pathinfo($resultToIndex[0]['executable_file_name'], PATHINFO_EXTENSION))
                ->sortBy('timestamp')
                ->last();
            $exe_url = Storage::cloud()->url($exe_file['path']);
            $exe_name = $exe_file['name'];

            $img = array();
            if ($resultToIndex[0]['pic_file_name1'] != null){
                $img1_file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($resultToIndex[0]['pic_file_name1'], PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($resultToIndex[0]['pic_file_name1'], PATHINFO_EXTENSION))
                    ->sortBy('timestamp')
                    ->last();
                $img1_url = Storage::cloud()->url($img1_file['path']);
                array_push($img,$img1_url);
            }
            if ($resultToIndex[0]['pic_file_name2'] != null){
                $img2_file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($resultToIndex[0]['pic_file_name2'], PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($resultToIndex[0]['pic_file_name2'], PATHINFO_EXTENSION))
                    ->sortBy('timestamp')
                    ->last();
                $img2_url = Storage::cloud()->url($img2_file['path']);
                array_push($img,$img2_url);
            }
            if ($resultToIndex[0]['pic_file_name3'] != null){
                $img3_file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($resultToIndex[0]['pic_file_name3'], PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($resultToIndex[0]['pic_file_name3'], PATHINFO_EXTENSION))
                    ->sortBy('timestamp')
                    ->last();
                $img3_url = Storage::cloud()->url($img3_file['path']);
                array_push($img,$img3_url);
            }
            if ($resultToIndex[0]['pic_file_name4'] != null){
                $img4_file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($resultToIndex[0]['pic_file_name4'], PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($resultToIndex[0]['pic_file_name4'], PATHINFO_EXTENSION))
                    ->sortBy('timestamp')
                    ->last();
                $img4_url = Storage::cloud()->url($img4_file['path']);
                array_push($img,$img4_url);
            }
            if ($resultToIndex[0]['pic_file_name5'] != null){
                $img5_file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($resultToIndex[0]['pic_file_name5'], PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($resultToIndex[0]['pic_file_name5'], PATHINFO_EXTENSION))
                    ->sortBy('timestamp')
                    ->last();
                $img5_url = Storage::cloud()->url($img5_file['path']);
                array_push($img,$img5_url);
            }

            $material_file = $contents
                ->where('type', '=', 'file')
                ->where('filename', '=', pathinfo($resultToIndex[0]['material'], PATHINFO_FILENAME))
                ->where('extension', '=', pathinfo($resultToIndex[0]['material'], PATHINFO_EXTENSION))
                ->sortBy('timestamp')
                ->last();
            if (isset($material_file)){
                $material_url = Storage::cloud()->url($material_file['path']);
                $material_name = $material_file['name'];
            }else{
                $material_url = '';
                $material_name = '';
            }

            return view('admin_frontend.result',
                compact('resultToIndex','project_name','project_member',
                    'video_url','exe_url','exe_name','img','material_url','material_name'));
        }
    }
}
