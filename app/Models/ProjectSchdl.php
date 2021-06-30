<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectSchdl extends Model
{
    use SoftDeletes;

    protected $table = 'project_schdl';  //指定資料表

    protected $fillable = [
        'project_id','name','schdl_start_date','schdl_end_date','file_name',
        'pa_start_date','pa_start_time','pa_end_date','pa_end_time','remark'  //欄位
    ];

    public function project(): BelongsTo //專案
    {
        return $this->belongsTo('App\Models\Project','project_id');
    }

    public function project_pa(): HasMany //專案考核
    {
        return $this->hasMany('App\Models\SchdlProjectPa');
    }

    public function member_pa(): HasMany //成員考核
    {
        return $this->hasMany('App\Models\SchdlMemberPa');
    }
}
