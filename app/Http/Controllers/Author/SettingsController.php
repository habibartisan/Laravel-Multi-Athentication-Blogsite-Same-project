<?php

namespace App\Http\Controllers\Author;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        return view('author.settings');
    }

    public function updateProfile(Request $request){

        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'image'=>'required|image'
        ]);
        $user = User::findOrFail(Auth::id());

        if($request->has('image')){
            if (User::find($user)){
                Storage::delete(User::find($user));
            }

            $path=$request->file('image')->store('setting_author_image');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $path;
        $user->about = $request->about;
        $user->save();
        Toastr::success('Profile Successfully Updated :)','Success');
        return redirect()->back();

    }

    public function updatePassword(Request $request){

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password,$hashedPassword))
        {
            if (!Hash::check($request->password,$hashedPassword))
            {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Password Successfully Changed','Success');
                Auth::logout();
                return redirect()->back();
            } else {
                Toastr::error('New password cannot be the same as old password.','Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Current password not match.','Error');
            return redirect()->back();
        }

    }
}
