<?php

namespace App\Http\Controllers\User;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function uploadUserImages(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $userId = $request->input('user_id');
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    if ($request->hasfile('images')) {
        foreach ($request->file('images') as $file) {
            $name = time() . rand(1, 100) . '.' . $file->extension();
            $file->move(public_path('images'), $name);
            $user->images()->create(['filename' => $name]);
        }
    }

    return response()->json(['success' => 'Images uploaded successfully.']);
}
}
















// public function uploadUserImages(Request $request)
//     {
//         $request->validate([
//             'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
//         ]);

//         $user = User::where('email', $request->email)->first();

//         if ($user) {
//             foreach ($request->file('images') as $image) {
//                 $path = $image->store('images');

//                 UserImage::create([
//                     'user_id' => $user->id,
//                     'image_path' => $path
//                 ]);
//             }

//             return response()->json(['message' => 'Images uploaded successfully'], 200);
//         } else {
//             return response()->json(['message' => 'User not found'], 404);
//         }


//     }
