<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new User;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->guard('user')->attempt($validator->validated())) {
            return response()->json(['error' => 'Email or Password is worng'], 200);
        }
        return $this->createNewToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), User::rules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "password" => Hash::make($request->input("password")),
        ]);

        $userPhoto = $request->file('user_photo');

        if ($userPhoto) {
            $userPhoto->store('user_photo', 'public'); // Stores the file in the public disk
            $user->user_photo = $userPhoto->hashName(); // Save the filename in the user model
            $user->save(); // Save the user object
        }

        $verificationToken = $this->generateToken($request->input("email"));

        $userPhotoUrl = null;

        if ($userPhoto) {
            $userPhotoPath = $user->user_photo;
            $userPhotoUrl = url('storage/user_photo/' . $userPhotoPath);
        }

        return response()->json([
            'message' => 'User successfully registered',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'user_photo' => $userPhotoUrl,
            ],
            'verification_token' => $verificationToken->verification_token,
        ], 201);
    }

    public function logout(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if ($user) return response()->json(['message' => 'User successfully signed out']);
    }

    public function userProfile(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'status' => '404',
                'message' => 'User not found'
            ], 404);
        }

        $profilePhotoUrl = null;
        if ($user->user_photo) {
            $profilePhotoPath = $user->user_photo;
            $profilePhotoUrl = url('storage/user_photo/' . $profilePhotoPath);
        }

        $images = Image::where('user_id', $user->id)->get('filename');

        $imageUrls = [];

        foreach ($images as $image) {
            $imageUrls[] = url('storage/follow-up/' . $image->filename);
        }

        return response()->json([
            'status' => '200',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'user_photo' => $profilePhotoUrl,
            ],
            'image_urls' => $imageUrls
        ]);
    }

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'user_photo' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->user_photo) {
            // Delete the previous profile photo if it exists
            Storage::disk('public')->delete($user->user_photo);
        }

        $imageName = Str::random(32) . "." . $request->user_photo->getClientOriginalExtension();
        $request->user_photo->storeAs('user_photo', $imageName, 'public');
        $user->user_photo = $imageName;
        $user->save();

        $profilePhotoUrl = url('storage/user_photo/' . $imageName);

        return response()->json(['message' => 'Profile image uploaded successfully', 'user_photo_url' => $profilePhotoUrl], 200);
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->guard('user')->user()
        ]);
    }

    public function generateToken($email)
    {
        $token = substr(md5(rand(0, 9) . $email . time()), 0, 32);
        $userNewToken = $this->model->whereEmail($email)->first();
        $userNewToken->verification_token = $token;
        $userNewToken->save();

        return $userNewToken;
    }
}