<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Member extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'member';  //指定資料表

    protected $fillable = [
        'student_ID','name','password','email','join_year','title','skill','remark'  //欄位
    ];
}
