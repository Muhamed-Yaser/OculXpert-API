<?php
namespace App\Http\Controllers\Admin;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function addDoctors (Request $request){

            Doctor::create([
                'name' =>$request->input('name'),
                'email'=>$request->input('email'),
                'password'=> Hash::make($request->input('password')),
             ]);
             return response()->json([
                'status' => '200',
                'Message'=>"Doctor added successfully"
             ]);

    }
    public function showDoctors (){


            $doctors = Doctor::all();
            return response()->json([
            'status' => '200',
            'Message'=>$doctors
        ]);

    }
    public function updateDoctors (Request $request ,$id){

            $doctor= Doctor::find($id);
            $doctor->update([
                'name' =>$request->input('name'),
                'email'=>$request->input('email'),
                'password'=> Hash::make($request->input('password'))
            ]);

    }
    public function destroyDoctor($id){


           $doctor=Doctor::findOrFail($id)->delete();
           return response()->json([
            'status' => '200',
            'Message'=>"Doctor deleted successfully" ]);
        }
}