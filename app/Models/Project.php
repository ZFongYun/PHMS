<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $table = 'project';  //指定資料表

    protected $fillable = [
        'name','content','school_year','semester',
        'start_date','end_date','status'  //欄位
    ];
}
