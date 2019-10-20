<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
    * Author: shamscorner
    * DateTime: 20/October/2019 - 17:20:09
    *
    * edit profile information
    *
    */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('profile', compact('user'));
    }

    /**
    * Author: shamscorner
    * DateTime: 20/October/2019 - 18:13:50
    *
    * update the user's data
    *
    */
    public function update(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'profile_image'=> 'image',
            'password' => 'confirmed'
        ]);

        $image = $request['profile_image'];

        $slug = Str::slug($data['name']);

        $user = User::findOrFail(auth()->id());

        // update the image
        $imageName = Utils::updateImage($image, [
            'slug' => $slug,
            'path' => 'profiles',
            'oldImage' => $user->profile_image,
            'isResizable' => true,
            'width' => 100,
            'height' => 100
        ]);

        $data['profile_image'] = $imageName;

        if (isset($request->password)) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);

        return back()->with('status', 'Profile updated!');
    }
}
