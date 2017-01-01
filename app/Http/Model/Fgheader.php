<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Fgheader extends Model
{
    protected $table = 'header';
    protected $primaryKey = 'h_id';
    public $timestamps = false;
    //排除不可操作的数据
    protected $guarded = [];
}
