<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchdlProjectPa extends Model
{
    use SoftDeletes;

    protected $table = 'schdl_project_pa';  //指定資料表

    protected $fillable = [
        'project_schdl_id','project_id','score','explanation'  //欄位
    ];
}
