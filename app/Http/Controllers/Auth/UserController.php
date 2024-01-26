<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->guard('user')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    public function logout() {
        if (auth()->guard('user')->check()){
            auth()->guard('user')->logout();
            return response()->json(['message' => 'User successfully signed out']);
            }
            else
            {
                return response()->json([
                    "status" => '401',
                    "Message" => 'U are unauthorized'
                ]);
            }
    }

    public function userProfile() {
        if (auth()->guard('user')->check()){

            $userData = Auth::guard('user')->user();
            return response()->json([
            "status" => '200',
            "Message" => $userData
        ]);
            }
            else {
                return response()->json([
                    "status" => '401',
                    "Message" => 'U are unauthorized'
                ]);
            }      }
            protected function createNewToken($token){
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    // 'expires_in' => auth()->factory()->getTTL() * 60,
                    'user' => auth()->user()
                ]);
            }
}
