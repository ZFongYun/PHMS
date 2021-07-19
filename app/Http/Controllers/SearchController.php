<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberPosition;
use App\Models\Project;
use Illuminate\Http\Request;

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
}
