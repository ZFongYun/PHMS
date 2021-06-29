<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectMember extends Model
{
    use SoftDeletes;

    protected $table = 'project_member';  //指定資料表

    protected $fillable = [
        'project_id','member_id'  //欄位
    ];
}
