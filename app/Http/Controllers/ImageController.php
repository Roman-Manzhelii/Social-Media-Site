<?php

// https://laravelamit.medium.com/how-to-upload-profile-image-of-user-in-laravel-upload-profile-picture-in-laravel-registration-732e4a0d349f
// https://stackoverflow.com/questions/31893439/image-validation-in-laravel-5-intervention

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request){

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $image_path = $request->file('image')->store('images', 'public');
    
        $user = $request->user();
    
        if ($user) {

            $user->image = $image_path;
            $user->save();
    
            return redirect()->back()->with('success', 'Image uploaded successfully.');
        }
    
        return redirect()->back()->with('error', 'User not authenticated.');

    }
    
}