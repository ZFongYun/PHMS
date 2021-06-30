<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchdlProjectPa extends Model
{
    use SoftDeletes;

    protected $table = 'schdl_project_pa';  //指定資料表

    protected $fillable = [
        'project_schdl_id','project_id','score','explanation'  //欄位
    ];

    public function project_schdl(): BelongsTo //屬於哪個進度
    {
        return $this->belongsTo('App\Models\ProjectSchdl','project_schdl_id');
    }

    public function project(): BelongsTo //屬於哪個專案
    {
        return $this->belongsTo('App\Models\Project','project_id');
    }
}
