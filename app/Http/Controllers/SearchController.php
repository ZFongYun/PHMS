<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberPosition;
use App\Models\Project;
use App\Models\ProjectSchdl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    protected $member;
    protected $project;

    public function __construct(Member $member, Project $project)
    {
        $this->member = $member;
        $this->project = $project;
    }


    public function hr_search(Request $request){
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
    }

    public function pm_search(Request $request){
        $target = $request->input('target');
        $keyword = $request->input('keyword');
        $keyword_status = $request->input('keyword_status');

        if ($target == 0){
            $projects = Project::where('school_year',$keyword)->get();
        }elseif ($target == 1){
            $projects = Project::where('name','like','%'.$keyword.'%')->get();
        }elseif ($target == 2){
            $projects = Project::where('status',$keyword_status)->get();
        }

        return $projects;
    }

    public function member_pm_search(Request $request){
        $target = $request->input('target');
        $keyword = $request->input('keyword');
        $keyword_status = $request->input('keyword_status');

        $member_id = auth('member')->user()->id;

        if ($target == 0){
            $projects = DB::table('project_member')
                ->where('member_id',$member_id)->whereNull('project_member.deleted_at')
                ->join('project','project_member.project_id','=','project.id')
                ->select('project.*')
                ->where('project.school_year',$keyword)
                ->orderByRaw('id asc')
                ->get()->toArray();
        }elseif ($target == 1){
            $projects = DB::table('project_member')
                ->where('member_id',$member_id)->whereNull('project_member.deleted_at')
                ->join('project','project_member.project_id','=','project.id')
                ->select('project.*')
                ->where('project.name','like','%'.$keyword.'%')
                ->orderByRaw('id asc')
                ->get()->toArray();
        }elseif ($target == 2){
            $projects = DB::table('project_member')
                ->where('member_id',$member_id)->whereNull('project_member.deleted_at')
                ->join('project','project_member.project_id','=','project.id')
                ->select('project.*')
                ->where('project.status',$keyword_status)
                ->orderByRaw('id asc')
                ->get()->toArray();
        }

        return $projects;
    }

    public function schdl_search(Request $request){
        $target = $request->input('target');
        $keyword = $request->input('keyword');
        $keyword_status = $request->input('keyword_status');
        $project_id = $request->input('project_id');
        $current_time = date("Y-m-d H:i:s");

        if ($target == 0){
            $schdls = ProjectSchdl::where('project_id',$project_id)
                ->where('name','like','%'.$keyword.'%')->get();
        }else{
            $schdl = ProjectSchdl::where('project_id',$project_id)->get();
            if ($keyword_status == 0){
                $schdls = array();
                foreach ($schdl as $item){
                    $limit = date($item['pa_end_date'] . " " . $item['pa_end_time']);
                    if ($current_time <= $limit){
                        $schdl_tmp = ProjectSchdl::where('id',$item['id'])->get(); //取得符合"考核中"條件的項目
                        foreach ($schdl_tmp as $value) {
                            array_push($schdls,$value);
                        }
                    }
                }
            }elseif ($keyword_status == 1){
                $schdls = array();
                foreach ($schdl as $item){
                    $limit = date($item['pa_end_date'] . " " . $item['pa_end_time']);
                    if ($current_time >= $limit){
                        $schdl_tmp = ProjectSchdl::where('id',$item['id'])->get(); //取得符合"已結束"條件的項目
                        foreach ($schdl_tmp as $value) {
                            array_push($schdls,$value);
                        }
                    }
                }
            }
        }
        return $schdls;
    }

    public function admin_schdl_search(Request $request){
        $keyword = $request->input('keyword');
        $project_id = $request->input('project_id');

        $schdls = ProjectSchdl::where('project_id',$project_id)
            ->where('name','like','%'.$keyword.'%')->get();

        return $schdls;
    }


}
