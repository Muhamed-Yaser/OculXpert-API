<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function showComments (){

        if (auth()->guard('admin')->check()){

            $comments = Comment::with([
                'user' , 'doctor'
             ])->get();
            return response()->json([
            'status' => '200',
            'Message'=>$comments
        ]);
        }else
        {
            return response()->json([
                "status" => '401',
                "Message" => 'U are unauthorized'
            ]);
        }
    }
    public function destroyComment($id){
        if (auth()->guard('admin')->check()){

           $comment=Comment::findOrFail($id)->delete();
           return response()->json([
            'status' => '200',
            'Message'=>"Comment deleted successfully" ]);
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
