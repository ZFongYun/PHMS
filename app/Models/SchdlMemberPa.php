<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchdlMemberPa extends Model
{
    use SoftDeletes;

    protected $table = 'schdl_member_pa';  //指定資料表

    protected $fillable = [
        'project_schdl_id','member_id','score','explanation'  //欄位
    ];
}
