<?php

namespace App\Http\Controllers\Admin;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($request->has('image')) {
            $path = $request->file('image')->store('catagory_image');
        }
        Category::create([
        'name'=>$request->name,
        'image'=>$path
    ]);
        Toastr::success('Category Successfully Saved :)' ,'Success');
        return redirect()->route('admin.category.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->has('image')){
            if (Category::find($id)->image){
                Storage::delete(Category::find($id)->image);
            }

            $path=$request->file('image')->store('catagory_image');
            Category::find($id)->update([
                'image'=>$path
            ]);
        }

        Category::find($id)->update([
            'name'=> $request->name,
            'image'=>$path

        ]);
        Toastr::success('Category Successfully Saved :)' ,'Success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Storage::delete(Category::findOrFail($id)->image);
        Category::find($id)->delete();
        Toastr::success('Category Successfully Delete :)' ,'Success');
        return back();
    }
}
