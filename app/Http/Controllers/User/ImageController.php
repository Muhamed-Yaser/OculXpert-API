<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Image;
use App\Models\UserImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{

    public function uploadUserImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'user_photos.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        $filenames = [];
        foreach ($request->file('user_photos') as $photo) {
            $imageName = Str::random(32) . '.' . $photo->getClientOriginalExtension();
            $filenames[] = $imageName;
            Storage::disk('public')->put('images/' . $imageName, file_get_contents($photo));
        }

        foreach ($filenames as $filename) {
            $images = Image::create([
                'user_id' => $user->id,
                'filename' => $filename,
            ]);
        }

        return response()->json([
            'success' => 'Images uploaded successfully.',
            'imagesUploadedData' => $images
        ],201);
    }
}
