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

        if (auth()->guard('admin')->check()){
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
        else
        {
            return response()->json([
                "status" => '401',
                "Message" => 'U are unauthorized'
            ]);
        }
    }
    public function showDoctors (){

        if (auth()->guard('admin')->check()){

            $doctors = Doctor::all();
            return response()->json([
            'status' => '200',
            'Message'=>$doctors
        ]);
        }
        else
        {
            return response()->json([
                "status" => '401',
                "Message" => 'U are unauthorized'
            ]);
        }
    }
    public function updateDoctors (Request $request ,$id){
        if (auth()->guard('admin')->check()){
            $doctor= Doctor::find($id);
            $doctor->update([
                'name' =>$request->input('name'),
                'email'=>$request->input('email'),
                'password'=> Hash::make($request->input('password'))
            ]);
        }
    }
    public function destroyDoctor($id){
        if (auth()->guard('admin')->check()){

           $doctor=Doctor::findOrFail($id)->delete();
           return response()->json([
            'status' => '200',
            'Message'=>"Doctor deleted successfully" ]);
        }
        else
        {
            return response()->json([
                "status" => '401',
                "Message" => 'U are unauthorized'
            ]);
        }
    }
}
