<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\React;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactController extends Controller
{
    public function showReacts (){



            $reacts = React::with([
                'user' , 'doctor'
             ])->get();
            return response()->json([
            'status' => '200',
            'Message'=>$reacts
        ]);

    }
    public function destroyReact($id){


           $react=React::findOrFail($id)->delete();
           return response()->json([
            'status' => '200',
            'Message'=>"React deleted successfully" ]);
        
    }
}