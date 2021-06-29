<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberProject extends Model
{
    use SoftDeletes;

    protected $table = 'member_project';  //指定資料表

    protected $fillable = [
        'member_id','project_id'  //欄位
    ];
}
