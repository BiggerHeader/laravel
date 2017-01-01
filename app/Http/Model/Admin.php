<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
}
