<?php

namespace App\Http\Controllers\Auth;

use App\Models\Doctor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->guard('doctor')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function logout()
    {

        auth()->guard('doctor')->logout();
        return response()->json(['message' => 'Doctor successfully signed out']);
    }
    public function doctorProfile(Request $request)
    {
        $email = $request->input('email');
        $doctorData = Doctor::where('email', $email)->first();

        $doctorPhotoUrl = Storage::url('doctors/' . $doctorData->doctor_photo);
        $doctorData->doctor_photo_url = $doctorPhotoUrl;

        return response()->json([
            "status" => '200',
            "Message" => $doctorData
        ]);
    }

    public function uploadDoctorProfileImage(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'doctor_photo' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $doctor = Doctor::where('email', $request->email)->first();

        if (!$doctor) {
            return response()->json(['message' => 'doctor not found'], 404);
        }

        $imageName = Str::random(32) . "." . $request->doctor_photo->getClientOriginalExtension();
        $filePath = 'doctor_photo/' . $imageName;
        Storage::disk('public')->put($filePath, file_get_contents($request->doctor_photo));
        $doctor->doctor_photo = $imageName;
        $doctor->save();

        return response()->json(['message' => 'Doctor Profile image uploaded successfully'], 201);
    }

    public function allDoctors ()
    {
        $doctors = Doctor::all();
        if($doctors) return ([
            "Status"=>200,
            "All doctors" => $doctors
        ]);
    }
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'doctor' => auth()->guard('doctor')->user()
        ]);
    }
}
