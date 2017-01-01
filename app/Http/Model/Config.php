<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'cfg';
    protected $primaryKey = 'cfg_id';
    public $timestamps = false;
    //排除不可操作的数据
    protected $guarded = [];
}
