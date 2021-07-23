<?php

namespace App\Http\Controllers;

use App\Models\SchdlMemberPa;
use App\Models\SchdlProjectPa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    protected $schdl_project_pa;
    protected $schdl_member_pa;

    public function __construct(SchdlProjectPa $schdl_project_pa, SchdlMemberPa $schdl_member_pa){
        $this->schdl_project_pa = $schdl_project_pa;
        $this->schdl_member_pa = $schdl_member_pa;
    }

    public function score_store(Request $request){
        $project_id = $request->input('project_id');
        $schdl_id = $request->input('schdl_id');
        $member_id_values = $request->input('member_id_values');
        $project_score = $request->input('project_score');
        $project_explanation = $request->input('project_explanation');
        $member_score_values = $request->input('member_score_values');
        $member_explanation_values = $request->input('member_explanation_values');

        $projectToStore = $this->schdl_project_pa;
        $projectToStore -> project_schdl_id = $schdl_id;
        $projectToStore -> project_id = $project_id;
        $projectToStore -> score = $project_score;
        $projectToStore -> explanation = $project_explanation;
        $projectToStore -> save();

        for ($i=0; $i<count($member_id_values); $i++){
            $memberToStore = new SchdlMemberPa();
            $memberToStore -> project_schdl_id = $schdl_id;
            $memberToStore -> member_id = $member_id_values[$i];
            $memberToStore -> score = $member_score_values[$i];
            $memberToStore -> explanation = $member_explanation_values[$i];
            $memberToStore -> save();
        }
        return back();
    }

    public function score_update(Request $request){
        $project_id = $request->input('project_id');
        $schdl_id = $request->input('schdl_id');
        $member_id_values = $request->input('member_id_values');
        $project_edit_score = $request->input('project_edit_score');
        $project_edit_explanation = $request->input('project_edit_explanation');
        $member_edit_score_values = $request->input('member_edit_score_values');
        $member_edit_explanation_values = $request->input('member_edit_explanation_values');

        $projectToUpdate = SchdlProjectPa::where('project_schdl_id',$schdl_id)->first();
        $projectToUpdate -> project_schdl_id = $schdl_id;
        $projectToUpdate -> project_id = $project_id;
        $projectToUpdate -> score = $project_edit_score;
        $projectToUpdate -> explanation = $project_edit_explanation;
        $projectToUpdate -> save();

        for ($i=0; $i<count($member_id_values); $i++){
            $memberToUpdate = SchdlMemberPa::where('project_schdl_id',$schdl_id)->where('member_id',$member_id_values[$i])->first();
            $memberToUpdate -> project_schdl_id = $schdl_id;
            $memberToUpdate -> member_id = $member_id_values[$i];
            $memberToUpdate -> score = $member_edit_score_values[$i];
            $memberToUpdate -> explanation = $member_edit_explanation_values[$i];
            $memberToUpdate -> save();
        }
        return back();
    }
}
