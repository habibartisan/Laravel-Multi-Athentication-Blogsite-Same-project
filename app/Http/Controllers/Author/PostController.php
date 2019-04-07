<?php

namespace App\Http\Controllers\Author;

use App\Category;
use App\Post;
use App\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $posts = Auth::user()->posts()->latest()->get();
     return view('author.post.index',compact('posts'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.create',compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'image' => 'required',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);

        if ($request->has('image')) {
            $path = $request->file('image')->store('add_image');
        }
        $slug = str_slug($request->title);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $path;
        $post->body = $request->body;
        if(isset($request->status))
        {
            $post->status = true;
        }else {
            $post->status = false;
        }
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);
    //email notification
        $users = User::where('role_id','1')->get();
        Notification::send($users, new NewAuthorPost($post));
    //end
        Toastr::success('Post Successfully Saved :)','Success');
        return redirect()->route('author.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if($post->user_id != Auth::id()){
            Toastr::error('You are not authorized to access this post','Error');
            return redirect()->back();
        }
        return view('author.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if($post->user_id != Auth::id()){
            Toastr::error('You are not authorized to access this post','Error');
            return redirect()->back();
        }
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.edit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        if($post->user_id != Auth::id()){
            Toastr::error('You are not authorized to access this post','Error');
            return redirect()->back();
        }
        $this->validate($request,[
            'title' => 'required',
            'image' => 'image',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);

        if($request->has('image')){
            if (Post::find($post)){
                Storage::delete(Post::find($post));
            }

            $path=$request->file('image')->store('add_image');
            $post->image =$path;
        }
        $slug = str_slug($request->title);

        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->body = $request->body;
        if(isset($request->status))
        {
            $post->status = true;
        }else {
            $post->status = false;
        }
        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('Post Successfully Updated :)','Success');
        return redirect()->route('author.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->user_id != Auth::id()){
            Toastr::error('You are not authorized to access this post','Error');
            return redirect()->back();
        }

        Storage::delete(Post::findOrFail($post));
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Post Successfully Deleted :)','Success');
        return redirect()->back();
    }
}