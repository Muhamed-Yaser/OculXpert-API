<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showUsers (){

            $users = User::all();
            return response()->json([
            'status' => '200',
            'Message'=>$users
        ]);

    }
    public function destroyUser($id){

           $user=User::findOrFail($id)->delete();
           return response()->json([
            'status' => '200',
            'Message'=>"User deleted successfully" ]);
    }
}
