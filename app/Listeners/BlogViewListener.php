<?php

namespace App\Listeners;


use App\Events\BlogView;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Session\Store;;

class BlogViewListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Store $session)
    {
        //
        $this->session =$session;
    }

    /**
     * Handle the event.
     *
     * @param  BlogView  $event
     * @return void
     */
    public function handle(BlogView $event)
    {
        //
        $post = $event->post;
        //先进行判断是否已经查看过
        if (!$this->hasViewedBlog($post)) {
            //保存到数据库
            $post->view_cache = $post->view_cache + 1;
            $post->save();
            //看过之后将保存到 Session
            $this->storeViewedBlog($post);
        }
    }

    protected function hasViewedBlog($post)
    {
     // new Request()->session();

        return array_key_exists($post->id, $this->getViewedBlogs());
    }

    protected function getViewedBlogs()
    {

        return $this->session->get('viewed_Blogs', []);
    }

    protected function storeViewedBlog($post)
    {
        $key = 'viewed_Blogs.'.$post->id;
        $this->session->put($key, time());
    }
}
