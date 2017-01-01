<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    protected $table = 'cate';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    //排除不可操作的数据
    protected $guarded = [];

    public static function notLimit($data, $parentid = 0, $level = 0)
    {
        static $reData = [];
        if (!empty($data)) {
            foreach ($data as $v) {
                if ($v['cate_pid'] == $parentid) {
                    $v['cate_name'] = str_repeat("-----", $level) . $v['cate_name'];
                    $reData[] = $v;
                    self::notLimit($data, $v['cate_id'], $level + 1);
                }
            }
        }
        return $reData;
    }

}
