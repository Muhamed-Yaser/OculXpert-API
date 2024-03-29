<?php
namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->guard('admin')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function logout() {
        if (auth()->guard('admin')->check()){
            auth()->guard('admin')->logout();
            return response()->json(['message' => 'Admin successfully signed out']);
            }
            else
            {
                return response()->json([
                    "status" => '401',
                    "Message" => 'U are unauthorized'
                ]);
            }
    }

    public function adminProfile() {
        if (auth()->guard('admin')->check()){

        $adminData = Auth::guard('admin')->user();
        return response()->json([
        "status" => '200',
        "Message" => $adminData
    ]);
        }
        else {
            return response()->json([
                "status" => '401',
                "Message" => 'U are unauthorized'
            ]);
        }
    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
