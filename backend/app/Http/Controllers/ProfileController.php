<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Image;

class ProfileController extends Controller
{
    function upload(Request $request)
    {
        $path = $request->file('profile_picture')->store('public', 'local');
        $pathArray = explode("/", $path);
        $imgPath = $pathArray[1];

        $img = new Image();
        $img->path = $imgPath;

        if ($img->save()) {
            return redirect('profile');; // Redirect to profile page
        } else {
            return "error! try after sometime";
        }
    }

    function show_profile_picture()
    {
        $image = Image::all();
        return view('profile', ['imgData' => $image]); // Send to profile view
    }
}




