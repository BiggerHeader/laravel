<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Cate;
use App\Http\Model\Leavemessage;
use App\Http\Model\Tag;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use Symfony\Component\HttpFoundation\Request;
use EndaEditor;

class IndexController extends CommonController
{
    public function index()
    {
        /*  get 与 all 的区别  ？？？*/
        //获取文章列表
        $list = Article::orderBy('art_time', 'desc')->paginate(5);
      //  dd($list);
        $this->getTags($list);
        return view('Home.index', compact('list'));

    }

    /*
     * 查看 类似的标签文档
     */
    public function sometag($tag_id)
    {
        $data = Article::where("art_tags","like","%$tag_id,%")->paginate(5);
        $list = $this->getTags($data);
        return view("Home.index",compact('list'));
    }
    /*
     * 获取一个分类下的所有子类 进行显示
     */
    public function cate($cate_id)
    {
        //先判断该分类是否还有子分类  获取子分类
        $sub = Cate::where("cate_pid",$cate_id)->select("cate_id","cate_name")->get();
        //判断集合是否为空
        $where = [];
        if($sub->isEmpty()){
            $where[] = $cate_id;
        }else{
            foreach ($sub as $c){
                 $where[]  = $c['cate_id'];
            }
        }
        //获取分类下所有的文章
        $art = Article::whereIn('cate_id', $where)->paginate(4);
        //获取分该类
        $cate = Cate::find($cate_id);

        // 修改查看次数
        Cate::where('cate_id', $cate_id)->increment('cate_view');
        return view('Home.cate', compact('cate', 'art', 'sub'));
    }
    /**
     * 把数字转换为标签
     */
    public function getTags($list)
    {
        foreach ($list as $l){
            $tag = "";
            $linka = Tag::whereIn("tag_id",array_filter(explode(",",$l->art_tags)))->get()->toArray();
            foreach ($linka as $t){
                $tag .= "<a href=\"/tag/".$t['tag_id']."\">".$t['tag_name']."</a>&nbsp;&nbsp;&nbsp;";
            }
            $l['art_tags'] = $tag;
        }
        return $list;
    }

    public function detail($art_id)
    {
        //获取相关分类下的文章  Join('cate', 'cate.cate_id', '=', 'article.cate_id')->
        $data = Article::Join('cate', 'cate.cate_id', '=', 'article.cate_id')->where('art_id', $art_id)->first();
        //根据art_id 获取 标签
        $tags =  Tag::whereIn("tag_id" ,explode(",",$data["art_tags"]))->get();

        //上一篇  注意 这里 不能直接对 id 进行 加减 法  还有 通过条件取数据后   进行排序  是最快捷的方法 同时也不能 进行加减法
        $point['pre'] = Article::where('art_id', '<', $art_id)->orderBy('art_id', 'desc')->first();
        $point['nxt'] = Article::where('art_id', '>', $art_id)->orderBy('art_id', 'desc')->first();

        //获取分类下的相关文章
        $relative = Article::where('cate_id', $data->cate_id)->orderBy('art_view', 'desc')->get();
        // 修改查看次数
        Article::where('art_id', $art_id)->increment('art_view');
        $id = $art_id;

        //查询出评论列表
        $leavemsgObj = new Leavemessage();
        $comment = $leavemsgObj->where("m_art_id",$id)->get();
        //调用cate模型的无限极分类的方法
        $comment = Leavemessage::notLimit($comment);
        //dd($data);
        return view('Home.detail', compact('data', 'point', 'relative', 'id', 'comment','tags'));
    }
    /**
     * 无限及分类
     */
    /**
     * 留言板处理
     * post
     * message
     */
    public function message()
    {
        if ($data = Input::except('_token')) {
            $v = Validator::make($data, [
                'm_email' => 'email',
                'm_url' => 'url',
                'm_name' => 'required'
            ], [
                'm_name.required' => '姓名必填',
                'm_email.required' => '邮箱必填',
            ]);
            if ($v->passes()) {
                $str = EndaEditor::MarkDecode($data['m_comment']);
                /*var_dump($str);
                var_dump($data['m_comment']);exit();*/

                $data['m_comment'] = $str;
                $res = Leavemessage::create($data);
                if ($res) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return $v->errors();
            }
        }
    }

    /**
     * 顶操作
     */
    public function up(Request $request)
    {
        if ('POST' === $request->getMethod()) {
            $data = Input::except('_token');

            if (is_numeric($data['m_id'])) {
                $return = Leavemessage::where("m_id", $data['m_id'])->select("m_up")->first()->toArray();;
                $return = $return['m_up'] + 1;
                $res = Leavemessage::where("m_id", $data['m_id'])->update(['m_up' => $return]);
                if ($res) {
                    return $return;
                } else {
                    return 0;
                }
            }
        }
    }

    /**
     * markdown 上传图片
     */
    public function upload()
    {

        // path 为 public 下面目录，比如我的图片上传到 public/uploads 那么这个参数你传uploads 就行了

        $data = EndaEditor::uploadImgFile('path');

        return json_encode($data);

    }
}
