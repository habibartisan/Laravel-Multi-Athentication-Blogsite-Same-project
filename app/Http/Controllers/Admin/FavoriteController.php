<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class FavoriteController extends Controller
{
    public function index()
    {
        $posts = Auth::user()->favorite_posts;
        return view('admin.favorite',compact('posts'));
    }
}
