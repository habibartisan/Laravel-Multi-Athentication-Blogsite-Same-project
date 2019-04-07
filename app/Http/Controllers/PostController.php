<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::latest()->approved()->published()->paginate(6);
        return view('posts',compact('posts'));
    }
    public function details($slug)
    {
        $post = Post::where('slug',$slug)->approved()->published()->first();

        $blogKey = 'blog_' . $post->id;

        if (!Session::has($blogKey)) {
            $post->increment('view_count');
            Session::put($blogKey,1);
        }

        //$randomposts = Post::all()->random(3);

        $randomposts = Post::approved()->published()->take(3)->inRandomOrder()->get();
        return view('post',compact('post','randomposts'));

    }

    public function postByCategory($name){
        $categorys=category::where('name',$name)->first();
        $posts = $categorys->posts()->approved()->published()->get();
        return view('category',compact('categorys','posts'));
    }

    public function postByTag($slug){
        $tag = Tag::where('slug',$slug)->first();
        return view('tag',compact('tag'));
    }



}
