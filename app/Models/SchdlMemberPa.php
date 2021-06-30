<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchdlMemberPa extends Model
{
    use SoftDeletes;

    protected $table = 'schdl_member_pa';  //指定資料表

    protected $fillable = [
        'project_schdl_id','member_id','score','explanation'  //欄位
    ];

    public function project_schdl(): BelongsTo //屬於哪個專案
    {
        return $this->belongsTo('App\Models\ProjectSchdl','project_schdl_id');
    }

    public function member(): BelongsTo //屬於哪個成員
    {
        return $this->belongsTo('App\Models\Member','member_id');
    }
}
