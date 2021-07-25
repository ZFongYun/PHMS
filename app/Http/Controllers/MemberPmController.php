<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectResult;
use App\Models\ProjectSchdl;
use App\Models\SchdlMemberPa;
use App\Models\SchdlProjectPa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MemberPmController extends Controller
{
    protected $member;
    protected $project;
    protected $project_schdl;
    protected $project_result;

    public function __construct(Member $member, Project $project, ProjectSchdl $project_schdl, ProjectResult $project_result)
    {
        $this->member = $member;
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
        $schdlToIndex = $this->project_schdl->where('project_id',$id)->get();
        $project = $this->project->find($id);
        $project_name = $project['name'];
        return view('member_frontend.schdlm',compact('id','schdlToIndex','project_name'));
    }

    public function schdlm_create($id){
        return view('member_frontend.schdlm_create',compact('id'));
    }

    public function schdlm_store(Request $request, $id){
        $validator = validator($request->all(),
            ['file' => 'required|mimes:pptx,rar,zip|max:100000'],
            [
                'file.required'=>'請選擇檔案',
                'file.mimes'=>'上傳格式錯誤',
                'file.max'=>'上傳檔案大小過大',
            ]);

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }else{
            $name = $request->input('name');
            $schdl_start = $request->input('schdl_start');
            $schdl_end = $request->input('schdl_end');
            $file = $request->file('file');
            $limit_end_date = $request->input('limit_end_date');
            $limit_end_time = $request->input('limit_end_time');
            $remark = $request->input('remark');
            $file_name = $file->getClientOriginalName();

            $schdlToStore = $this->project_schdl;
            $schdlToStore -> project_id = $id;
            $schdlToStore -> name = $name;
            $schdlToStore -> schdl_start_date = $schdl_start;
            $schdlToStore -> schdl_end_date = $schdl_end;
            $schdlToStore -> file_name = $file_name;
            $schdlToStore -> pa_end_date = $limit_end_date;
            $schdlToStore -> pa_end_time = $limit_end_time;
            $schdlToStore -> remark = $remark;
            $schdlToStore -> save();

            //將檔案存儲到雲端
            $filePath = $file->getPathName();
            $fileData = File::get($filePath);

            Storage::cloud()->put($file_name, $fileData);

            return redirect('/PHMS_member/pm/'.$id.'/schdlm');
        }
    }

    public function schdlm_download($id,$downloadId){
        $filename = ProjectSchdl::where('id',$downloadId)->value('file_name');

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

    public function schdlm_edit($id, $schdlId){
        $schdlToEdit = ProjectSchdl::where('id',$schdlId)->get()->toArray();

        $dir = '/';
        $recursive = false; //是否取得資料夾下的目錄
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));

        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($schdlToEdit[0]['file_name'], PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($schdlToEdit[0]['file_name'], PATHINFO_EXTENSION))
            ->sortBy('timestamp')
            ->last(); //在$contents找是否有符合的文件

        $url = Storage::cloud()->url($file['path']);
        $file_name = $file['name'];

        return view('member_frontend.schdlm_edit',compact('id','schdlToEdit','url','file_name'));
    }

    public function schdlm_update(Request $request, $id, $schdlId){
        $isRe = $request->input('isRe');
        $schdlToUpdate = $this->project_schdl->find($schdlId);

        if ($isRe == 0){ //未改
            $file_name = $schdlToUpdate['file_name'];
        }else{
            $validator = validator($request->all(),
                ['file' => 'required|mimes:pptx,rar,zip|max:100000'],
                [
                    'file.required'=>'請選擇檔案',
                    'file.mimes'=>'上傳格式錯誤',
                    'file.max'=>'上傳檔案大小過大',
                ]);
            if($validator->fails()) {
                return back()->withErrors($validator->errors());
            }else{
                $re_file = $request->file('file');
                $file_name = $re_file->getClientOriginalName();

                //將檔案存儲到雲端
                $filePath = $re_file->getPathName();
                $fileData = File::get($filePath);

                Storage::cloud()->put($file_name, $fileData);
            }
        }
        $name = $request->input('name');
        $schdl_start = $request->input('schdl_start');
        $schdl_end = $request->input('schdl_end');
        $limit_end_date = $request->input('limit_end_date');
        $limit_end_time = $request->input('limit_end_time');
        $remark = $request->input('remark');
        $schdlToUpdate -> project_id = $id;
        $schdlToUpdate -> name = $name;
        $schdlToUpdate -> schdl_start_date = $schdl_start;
        $schdlToUpdate -> schdl_end_date = $schdl_end;
        $schdlToUpdate -> file_name = $file_name;
        $schdlToUpdate -> pa_end_date = $limit_end_date;
        $schdlToUpdate -> pa_end_time = $limit_end_time;
        $schdlToUpdate -> remark = $remark;
        $schdlToUpdate -> save();
        return redirect('/PHMS_member/pm/'.$id.'/schdlm');
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

        return view('member_frontend.schdlm_pa',compact('schdl_name','id','schdlId','project_member','project_pa','member_pa','project_schdl'));
    }

    public function result($id){
        $is_null = $this->project_result->where('project_id',$id)->get()->toArray();
        $project_name = $this->project->find($id);

        if (empty($is_null)){
            return view('member_frontend.result_null',compact('project_name'));
        }else{
            return view('member_frontend.result',compact('project_name'));
        }
    }
}
