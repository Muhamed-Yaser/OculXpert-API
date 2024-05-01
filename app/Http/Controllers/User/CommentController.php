<?php
namespace App\Http\Controllers\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CommentController extends Controller
{
    public function addComment (Request $request){


            Comment::create([
                'doctor_id' => null,
                'user_id' => auth()->guard('user')->user()->id,
                'content'=>$request->input('content'),
                'post_id' => $request->input('post_id'),
            ]);
             return response()->json([
                'status' => '200',
                'Message'=>"User commented successfully"
             ]);

    }
    public function showComments (){



            $comments = Comment::with([
                'user' , 'doctor'
             ])->get();
            return response()->json([
            'status' => '200',
            'Message'=>$comments
        ]);

    }
     public function updateComment (Request $request ,$id){

            $comment= Comment::find($id);
            $comment->update([
                'content'=>$request->input('content')
            ]);
            return response()->json([
                'status' => '200',
                'Message'=>"Comment updated successfully"
             ]);

    }
    public function destroyComment($id){


           $comment=Comment::findOrFail($id)->delete();
           return response()->json([
            'status' => '200',
            'Message'=>"Comment deleted successfully" ]);

    }
}