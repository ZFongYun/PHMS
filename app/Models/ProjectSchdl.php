<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectSchdl extends Model
{
    use SoftDeletes;

    protected $table = 'project_schdl';  //指定資料表

    protected $fillable = [
        'project_id','name','schdl_start_date','schdl_end_date','file_name',
        'pa_start_date','pa_start_time','pa_end_date','pa_end_time','remark'  //欄位
    ];
}
