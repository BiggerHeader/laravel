<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Leavemessage extends Model
{
    protected $table = 'message';
    protected $primaryKey = 'm_id';
    public $timestamps = false;
    //排除不可操作的数据
    protected $guarded = [];


    public static function notLimit($data, $parentid = 0, $level = 0)
    {
        static $reData = [];
        if (!empty($data)) {
            foreach ($data as $v) {
                if ($v['m_parent'] == $parentid) {
                    $v['m_level'] = $level;
                    $reData[] = $v;
                    self::notLimit($data, $v['m_id'], $level + 1);
                }
            }
        }
        return $reData;
    }
}
