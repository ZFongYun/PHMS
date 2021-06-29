<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'admin';  //指定資料表

    protected $fillable = [
        'account','password','access'  //欄位
    ];
}
