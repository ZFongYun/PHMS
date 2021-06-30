<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectResult extends Model
{
    use SoftDeletes;

    protected $table = 'project_result';  //指定資料表

    protected $fillable = [
        'project_id','name','introduction','type','function','teacher','team','movie_file_name',
        'pic_file_name1','pic_file_name2','pic_file_name3','pic_file_name4','pic_file_name5',
        'executable_file_name','pm_material','gd_material','ga_material' //欄位
    ];

    public function project(): BelongsTo //專案
    {
        return $this->belongsTo('App\Models\Project','project_id');
    }
}
