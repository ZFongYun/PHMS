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
        $project_name = Project::where('id',$id)->value('name');

        if (empty($is_null)){
            return view('member_frontend.result_null',compact('id','project_name'));
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

            return view('member_frontend.result',
                compact('resultToIndex','project_name','project_member','video_url','exe_url','exe_name','img'));
        }
    }

    public function result_create($id){
        $project_member = DB::table('project_member')
            ->where('project_id',$id)->whereNull('project_member.deleted_at')
            ->join('member','project_member.member_id','=','member.id')
            ->select('member.name','member.title')
            ->get()->toArray();
        return view('member_frontend.result_create',compact('id','project_member'));
    }

    public function result_store($id, Request $request){
        $name = $request->input('name');
        $introduction = $request->input('introduction');
        $type = $request->input('type');
        $function = $request->input('function');
        $teacher = $request->input('teacher');
        $team = $request->input('team');
        $video = $request->file('video');
        $img = $request->file('img');
        $exe = $request->file('exe');
        $material = $request->file('material');

        $types = "";
        foreach ($type as $value){
            $types = $types . " " . $value;
        }

        $resultToStore = $this->project_result;
        $resultToStore->project_id = $id;
        $resultToStore->name = $name;
        $resultToStore->introduction = $introduction;
        $resultToStore->type = $types;
        $resultToStore->function = $function;
        $resultToStore->teacher = $teacher;
        $resultToStore->team = $team;
        if ($video != null){
            $resultToStore->movie_file_name = $video->getClientOriginalName();
        }

        $resultToStore->pic_file_name1 = $img[0]->getClientOriginalName();
        if (isset($img[1])){
            $resultToStore->pic_file_name2 = $img[1]->getClientOriginalName();
        }
        if (isset($img[2])){
            $resultToStore->pic_file_name3 = $img[2]->getClientOriginalName();
        }
        if (isset($img[3])){
            $resultToStore->pic_file_name4 = $img[3]->getClientOriginalName();
        }
        if (isset($img[4])){
            $resultToStore->pic_file_name5 = $img[4]->getClientOriginalName();
        }
        $resultToStore->executable_file_name = $exe->getClientOriginalName();
        if ($material != null){
            $resultToStore->material = $material->getClientOriginalName();
        }
        $resultToStore->save();

        //將檔案存儲到雲端
        if ($video != null){
            $video_path = $video->getPathName();
            $video_data = File::get($video_path);
            Storage::cloud()->put($video->getClientOriginalName(), $video_data);
        }

        foreach ($img as $item){
            $img_path = $item->getPathName();
            $img_data = File::get($img_path);
            Storage::cloud()->put($item->getClientOriginalName(), $img_data);
        }

        $exe_path = $exe->getPathName();
        $exe_data = File::get($exe_path);
        Storage::cloud()->put($exe->getClientOriginalName(), $exe_data);

        if ($material != null){
            $material_path = $material->getPathName();
            $material_data = File::get($material_path);
            Storage::cloud()->put($material->getClientOriginalName(), $material_data);
        }

        return redirect('/PHMS_member/pm/'.$id.'/result');
    }

    public function result_edit($id, $resultId){
        $resultToEdit = $this->project_result->where('id',$resultId)
            ->where('project_id',$id)->get()->toArray();
        $type_chk_arr = explode(" ",$resultToEdit[0]['type']);
        $project_member = DB::table('project_member')
            ->where('project_id',$id)->whereNull('project_member.deleted_at')
            ->join('member','project_member.member_id','=','member.id')
            ->select('member.name','member.title')
            ->get()->toArray();

        $dir = '/';
        $recursive = false; //是否取得資料夾下的目錄
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));
        $video_file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($resultToEdit[0]['movie_file_name'], PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($resultToEdit[0]['movie_file_name'], PATHINFO_EXTENSION))
            ->sortBy('timestamp')
            ->last();
        if (isset($video_file)){
            $video_url = Storage::cloud()->url($video_file['path']);
            $video_name = $video_file['name'];
        }else{
            $video_url = '';
            $video_name = '無';
        }

        $img1_file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($resultToEdit[0]['pic_file_name1'], PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($resultToEdit[0]['pic_file_name1'], PATHINFO_EXTENSION))
            ->sortBy('timestamp')
            ->last();
        if (isset($img1_file)){
            $img1_url = Storage::cloud()->url($img1_file['path']);
            $img1_name = $img1_file['name'];
        }else{
            $img1_url = '';
            $img1_name = '無';
        }

        $img2_file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($resultToEdit[0]['pic_file_name2'], PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($resultToEdit[0]['pic_file_name2'], PATHINFO_EXTENSION))
            ->sortBy('timestamp')
            ->last();
        if (isset($img2_file)){
            $img2_url = Storage::cloud()->url($img2_file['path']);
            $img2_name = $img2_file['name'];
        }else{
            $img2_url = '';
            $img2_name = '無';
        }

        $img3_file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($resultToEdit[0]['pic_file_name3'], PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($resultToEdit[0]['pic_file_name3'], PATHINFO_EXTENSION))
            ->sortBy('timestamp')
            ->last();
        if (isset($img3_file)){
            $img3_url = Storage::cloud()->url($img3_file['path']);
            $img3_name = $img3_file['name'];
        }else{
            $img3_url = '';
            $img3_name = '無';
        }

        $img4_file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($resultToEdit[0]['pic_file_name4'], PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($resultToEdit[0]['pic_file_name4'], PATHINFO_EXTENSION))
            ->sortBy('timestamp')
            ->last();
        if (isset($img4_file)){
            $img4_url = Storage::cloud()->url($img4_file['path']);
            $img4_name = $img4_file['name'];
        }else{
            $img4_url = '';
            $img4_name = '無';
        }

        $img5_file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($resultToEdit[0]['pic_file_name5'], PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($resultToEdit[0]['pic_file_name5'], PATHINFO_EXTENSION))
            ->sortBy('timestamp')
            ->last();
        if (isset($img5_file)){
            $img5_url = Storage::cloud()->url($img5_file['path']);
            $img5_name = $img5_file['name'];
        }else{
            $img5_url = '';
            $img5_name = '無';
        }

        $exe_file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($resultToEdit[0]['executable_file_name'], PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($resultToEdit[0]['executable_file_name'], PATHINFO_EXTENSION))
            ->sortBy('timestamp')
            ->last();
        $exe_url = Storage::cloud()->url($exe_file['path']);
        $exe_name = $exe_file['name'];

        $material_file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($resultToEdit[0]['material'], PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($resultToEdit[0]['material'], PATHINFO_EXTENSION))
            ->sortBy('timestamp')
            ->last();
        if (isset($material_file)){
            $material_url = Storage::cloud()->url($material_file['path']);
            $material_name = $material_file['name'];
        }else{
            $material_url = '';
            $material_name = '無';
        }

        return view('member_frontend.result_edit',
            compact('id','resultToEdit','type_chk_arr','project_member',
                'video_url','video_name','exe_url','exe_name','material_url','material_name',
                'img1_url','img1_name', 'img2_url','img2_name', 'img3_url','img3_name',
                'img4_url','img4_name', 'img5_url','img5_name'));
    }

    public function result_update(Request $request, $id, $resultId){
        $name = $request->input('name');
        $introduction = $request->input('introduction');
        $type = $request->input('type');
        $function = $request->input('function');
        $teacher = $request->input('teacher');
        $team = $request->input('team');
        $video = $request->file('video');
        $img = $request->file('img');
        $exe = $request->file('exe');
        $material = $request->file('material');
        $isVideoRe = $request->input('isVideoRe');
        $isImgRe = $request->input('isImgRe');
        $isExeRe = $request->input('isExeRe');
        $isMaterialRe = $request->input('isMaterialRe');
        $resultToUpdate = $this->project_result->find($resultId);

        if ($isVideoRe == 0){ //未改
            $video_name = $resultToUpdate['movie_file_name'];
        }else{
            $video_name = $video->getClientOriginalName();
            //將檔案存儲到雲端
            $video_path = $video->getPathName();
            $video_data = File::get($video_path);
            Storage::cloud()->put($video_name, $video_data);
        }

        if ($isImgRe == 0){ //未改
            $img1_name = $resultToUpdate['pic_file_name1'];
            $img2_name = $resultToUpdate['pic_file_name2'];
            $img3_name = $resultToUpdate['pic_file_name3'];
            $img4_name = $resultToUpdate['pic_file_name4'];
            $img5_name = $resultToUpdate['pic_file_name5'];
        }else{
            $img1_name = $img[0]->getClientOriginalName();
            if (isset($img[1])){
                $img2_name = $img[1]->getClientOriginalName();
            }
            if (isset($img[2])){
                $img3_name = $img[2]->getClientOriginalName();
            }
            if (isset($img[3])){
                $img4_name = $img[3]->getClientOriginalName();
            }
            if (isset($img[4])){
                $img5_name = $img[4]->getClientOriginalName();
            }
            foreach ($img as $item){
                $img_path = $item->getPathName();
                $img_data = File::get($img_path);
                Storage::cloud()->put($item->getClientOriginalName(), $img_data);
            }
        }

        if ($isExeRe == 0){ //未改
            $exe_name = $resultToUpdate['executable_file_name'];
        }else{
            $exe_name = $exe->getClientOriginalName();
            //將檔案存儲到雲端
            $exe_path = $exe->getPathName();
            $exe_data = File::get($exe_path);
            Storage::cloud()->put($exe_name, $exe_data);
        }

        if ($isMaterialRe == 0){ //未改
            $material_name = $resultToUpdate['material'];
        }else{
            $material_name = $material->getClientOriginalName();
            //將檔案存儲到雲端
            $material_path = $material->getPathName();
            $material_data = File::get($material_path);
            Storage::cloud()->put($material_name, $material_data);
        }

        $types = "";
        foreach ($type as $value){
            $types = $types . " " . $value;
        }

        $resultToUpdate->project_id = $id;
        $resultToUpdate->name = $name;
        $resultToUpdate->introduction = $introduction;
        $resultToUpdate->type = $types;
        $resultToUpdate->function = $function;
        $resultToUpdate->teacher = $teacher;
        $resultToUpdate->team = $team;
        if ($video != null){
            $resultToUpdate->movie_file_name = $video_name;
        }
        $resultToUpdate->pic_file_name1 = $img1_name;
        if (isset($img[1])){
            $resultToUpdate->pic_file_name2 = $img2_name;
        }
        if (isset($img[2])){
            $resultToUpdate->pic_file_name3 = $img3_name;
        }
        if (isset($img[3])){
            $resultToUpdate->pic_file_name4 = $img4_name;
        }
        if (isset($img[4])){
            $resultToUpdate->pic_file_name5 = $img5_name;
        }
        $resultToUpdate->executable_file_name = $exe_name;
        if ($material != null){
            $resultToUpdate->material = $material_name;
        }
        $resultToUpdate->save();

        return redirect('/PHMS_member/pm/'.$id.'/result');
    }

    public function format_download(){
        $file = public_path().'/storage/成果資料上傳格式.pdf';
        return response()->download($file);
    }
}
