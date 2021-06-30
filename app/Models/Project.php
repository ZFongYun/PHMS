<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use SoftDeletes;

    protected $table = 'project';  //指定資料表

    protected $fillable = [
        'name','content','school_year','semester',
        'start_date','end_date','status'  //欄位
    ];

    public function project(): BelongsToMany //參與過的專案
    {
        return $this->belongsToMany('App\Models\Project','member_project');
    }

    public function member(): BelongsToMany //專案成員
    {
        return $this->belongsToMany('App\Models\Member','project_member');
    }

    public function schdl(): HasMany //專案進度
    {
        return $this->hasMany('App\Models\ProjectSchdl');
    }

    public function project_pa(): HasMany //專案考核
    {
        return $this->hasMany('App\Models\SchdlProjectPa');
    }

    public function result(): HasMany //專案成果
    {
        return $this->hasMany('App\Models\ProjectResult');
    }
}
