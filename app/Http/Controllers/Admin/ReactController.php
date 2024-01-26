<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\React;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactController extends Controller
{
    public function showReacts (){

        if (auth()->guard('admin')->check()){

            $reacts = React::with([
                'user' , 'doctor'
             ])->get();
            return response()->json([
            'status' => '200',
            'Message'=>$reacts
        ]);
        }else
        {
            return response()->json([
                "status" => '401',
                "Message" => 'U are unauthorized'
            ]);
        }
    }
    public function destroyReact($id){
        if (auth()->guard('admin')->check()){

           $react=React::findOrFail($id)->delete();
           return response()->json([
            'status' => '200',
            'Message'=>"React deleted successfully" ]);
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
