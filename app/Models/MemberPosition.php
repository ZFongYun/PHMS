<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberPosition extends Model
{
    use SoftDeletes;

    protected $table = 'member_position';  //指定資料表

    protected $fillable = [
        'member_id','position'  //欄位
    ];
}
