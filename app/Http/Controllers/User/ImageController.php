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

        $imagesUploadedData = [];

        foreach ($request->file('user_photos') as $photo) {
            $imageName = Str::random(32) . '.' . $photo->getClientOriginalExtension();
            Storage::disk('public')->put('follow-up/' . $imageName, file_get_contents($photo));

            $image = Image::create([
                'user_id' => $user->id,
                'filename' => $imageName,
            ]);

            $imageUrl = url('storage/follow-up/' . $imageName);
            $image->filename = $imageUrl;

            $imagesUploadedData[] = $image;
        }

        return response()->json([
            'success' => 'Images uploaded successfully.',
            'imagesUploadedData' => $imagesUploadedData
        ], 201);
    }
}