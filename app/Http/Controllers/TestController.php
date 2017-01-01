<?php

namespace App\Http\Controllers;

use App\Events\BlogView;
use Illuminate\Support\Facades\Event;
use App\Http\Model\Admin;
use App\Test;
use Illuminate\Http\Request;

use App\Http\Requests;

class TestController extends Controller
{
    //
    public function showPost(Request  $slug)
    {

        $post = Test::whereSlug(1)->firstOrFail();
        Event::fire(new BlogView($post));
        return view('welcome')->withPost($post);
    }
}
