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
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), User::rules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imageName = Str::random(32) . "." . $request->file('user_photo')->getClientOriginalExtension();

        $user = User::create([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "password" => Hash::make($request->input("password")),
            "user_photo" => $imageName,
        ]);

        Storage::disk('public')->put($imageName, file_get_contents($request->file('user_photo')));

        $verificationToken = $this->generateToken($request->input("email"));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'user_photo' => $user->user_photo,
            ],
            'verification_token' => $verificationToken->verification_token,
        ], 201);
    }

    public function logout()
    {

        auth()->guard('user')->logout();
        return response()->json(['message' => 'User successfully signed out']);
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

        $images = Image::where('user_id', $user->id)->get('filename');

        return response()->json([
            'status' => '200',
            'user' => $user ,
            'images' => $images
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

        $imageName = Str::random(32) . "." . $request->user_photo->getClientOriginalExtension();
        Storage::disk('public')->put($imageName, file_get_contents($request->user_photo));
        $user->user_photo = $imageName;
        $user->save();

        return response()->json(['message' => 'Profile image uploaded successfully'], 200);
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
