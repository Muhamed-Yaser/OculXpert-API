<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new User;
    }

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
            'user_photo' => 'required|image|mimes:jpg,png,jpeg'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    [
                        'password' => bcrypt($request->password),
                        'user_photo' => $request->file('user_photo')->store('public/users')
                    ]
                ));

        $verificationToken = $this->generateToken($request->email);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'verification_token' => $verificationToken->verification_token,
        ], 201);
    }


    public function logout() {

            auth()->guard('user')->logout();
            return response()->json(['message' => 'User successfully signed out']);

    }

    public function userProfile() {


            $userData = Auth::guard('user')->user();
            return response()->json([
            "status" => '200',
            "Message" => $userData
        ]);
                }
            protected function createNewToken($token){
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    // 'expires_in' => auth()->factory()->getTTL() * 60,
                    'user' => auth()->guard('user')->user()
                ]);
            }

            public function generateToken($email) {
                $token = substr(md5(rand(0,9) .$email .time()) , 0 , 32);
                $userNewToken = $this->model->whereEmail($email)->first();
                $userNewToken->verification_token = $token;
                $userNewToken ->save() ;

                return $userNewToken;
            }
}
