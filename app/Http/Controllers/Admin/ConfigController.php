<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    public function index()
    {
        $data = Config::orderBy('cfg_order', 'desc')->get();
        foreach ($data as $v) {
            switch ($v->field_type) {
                case  'input':
                    $v->html = '<input type="text" class="lg" name="cfg_content[]" value="' . $v->cfg_content . '">';
                    break;
                case  'radio':
                    $arr = explode(',', $v->field_value);
                    $v->html = '';
                    foreach ($arr as $a) {
                        $val = explode('|', $a);
                        if ($v->cfg_content == 1 && $val[0] == 1) {
                            $checked = 'checked';
                            $v->html .= '<input type="radio"  name="cfg_content[]" value="' . $val[0] . '" ' . $checked . '>' . $val[1] . '     ';
                        } else if ($v->cfg_content == 0 && $val[0] == 0) {
                            $v->html .= '<input type="radio"  name="cfg_content[]" value="' . $val[0] . '" checked>' . $val[1] . '    ';
                        } else {
                            $v->html .= '<input type="radio"  name="cfg_content[]" value="' . $val[0] . '" >' . $val[1] . '    ';
                        }
                    }
                    break;

                case  'textarea':
                    $v->html = '<textarea rows="5" cols="15" name="cfg_content[]">' . $v->cfg_content . '</textarea>';
                    break;
            }
        }
        return view('Admin.config.index', compact('data'));
    }

    /**
     * 修改配置表的cfg_content
     */
    public function cfgcontent()
    {
        $data = Input::except('_token', 'ord');
        foreach ($data['cfg_id'] as $k => $v) {
            Config::where('cfg_id', $v)->update(['cfg_content' => $data['cfg_content'][$k]]);
        }
        // 修改配置信息
        $this->becfgfile();
        return back()->with('errors', '网站的配置项更新成功');
    }

    /**
     * 生成配置项文件
     */
    public function becfgfile()
    {
        //用 pluck 进行筛选 需要的字段
        $data = Config::pluck('cfg_content', 'cfg_name')->all();
        $path = str_replace("\\","/",base_path()).'/config/web.php';
        //返回变量的结构信息 它和 var_dump() 类似，不同的是其返回的表示是合法的 PHP 代码。
        $array = '<?php return  ' . var_export($data ,true) . '?>';
        file_put_contents($path, $array);
    }

    /**
     *排序
     */
    public function cfgorder()
    {
        if ($data = Input::all()) {
            $isExist = Config::find($data['cfg_id']);
            if ($isExist) {
                $isExist->cfg_order = $data['val'];
                $res = $isExist->update();
                if ($res) {
                    return 1;
                } else {
                    return 0;
                }
            }
        }
        return 0;

    }

    /**
     * method :get
     * 添加友情链接页面显示
     */
    public
    function create()
    {
        return view('Admin.config.add');
    }

    /**
     * method : post
     * 添加分类提交
     */
    public
    function store()
    {
        if ($data = Input::except('_token')) {
            //验证规则
            $ruls = [
                'cfg_title' => 'required',
                'cfg_name' => 'required',
                'cfg_order' => 'numeric'
            ];
            //提示信息
            $msg = [
                'cfg_name.required' => '名称必填',
                'cfg_title.required' => '标题必填',
            ];
            //获取验证对象
            $validate = Validator::make($data, $ruls, $msg);
            if ($validate->passes()) {
                //添加导数据库  用create 方法
                $res = Config::create($data);
                if ($res) {
                    return redirect('admin/config');
                } else {
                    return back()->with('数据添加错误');
                }
            } else {
                return back()->withErrors($validate);
            }

        }
        return view('Admin.config.index');
    }

    /**
     * 删除 delete 方法
     */
    public
    function destroy($config_id)
    {
        $res = Config::where("cfg_id", $config_id)->delete();
        if ($res) {
            // 修改配置信息
            $this->becfgfile();
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 编辑
     */
    public
    function edit($config_id)
    {
        $field = Config::find($config_id);
        return view('Admin.config.edit', compact('field'));
    }

    /**
     * 更改
     */
    public
    function update($config_id)
    {
        if ($data = Input::except('_token', '_method')) {
            if ($data['field_type'] == 'input' || $data['field_type'] == 'textarea') {
                $data['field_value'] = '';
            }
            $res = Config::where("cfg_id", $config_id)->update($data);
            if ($res) {
                // 修改配置信息
                $this->becfgfile();
                return redirect('admin/config');
            } else {
                return back()->with('errors', '更新失败');
            }
        }
    }
}
