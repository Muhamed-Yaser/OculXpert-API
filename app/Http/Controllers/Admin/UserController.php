<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showUsers (){

        if (auth()->guard('admin')->check()){

            $users = User::all();
            return response()->json([
            'status' => '200',
            'Message'=>$users
        ]);
        }else
        {
            return response()->json([
                "status" => '401',
                "Message" => 'U are unauthorized'
            ]);
        }
    }
    public function destroyUser($id){
        if (auth()->guard('admin')->check()){

           $user=User::findOrFail($id)->delete();
           return response()->json([
            'status' => '200',
            'Message'=>"User deleted successfully" ]);
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
