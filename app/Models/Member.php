<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'member';  //指定資料表

    protected $fillable = [
        'student_ID','name','password','email','join_year','title','skill','remark'  //欄位
    ];

    public function position(): HasMany
    {
        return $this->hasMany('App\Models\MemberPosition');
    }

    public function project(): BelongsToMany //參與過的專案
    {
        return $this->belongsToMany('App\Models\Project','member_project');
    }

    public function member(): BelongsToMany //專案成員
    {
        return $this->belongsToMany('App\Models\Member','project_member');
    }

    public function member_pa(): HasMany //成員考核
    {
        return $this->hasMany('App\Models\SchdlMemberPa');
    }
}
