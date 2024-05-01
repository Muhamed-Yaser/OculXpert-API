<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->guard('doctor')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function logout() {

            auth()->guard('doctor')->logout();
            return response()->json(['message' => 'Doctor successfully signed out']);
    }
    public function doctorProfile() {


            $doctorData = Auth::guard('doctor')->user();
            return response()->json([
            "status" => '200',
            "Message" => $doctorData
        ]);
    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'doctor' => auth()->guard('doctor')->user()
        ]);
    }
}
