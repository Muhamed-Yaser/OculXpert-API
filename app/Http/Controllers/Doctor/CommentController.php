<?php
namespace App\Http\Controllers\Doctor;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CommentController extends Controller
{
    public function addComment (Request $request){

        if (auth()->guard('doctor')->check()){
            Comment::create([
                'user_id' => null,
                'doctor_id' => auth()->guard('doctor')->user()->id??'No Comments yet',
                'content'=>$request->input('content'),
                'post_id' => $request->input('post_id'),
            ]);
             return response()->json([
                'status' => '200',
                'Message'=>"Doctor commented successfully"
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
    public function showComments (){

        if (auth()->guard('doctor')->check()){

            $comments = Comment::with([
                'user' , 'doctor'
             ])->get();
            return response()->json([
            'status' => '200',
            'Message'=>$comments
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
    public function updateComment (Request $request ,$id){
        if (auth()->guard('doctor')->check()){
            $comment= Comment::find($id);
            $comment->update([
                'content'=>$request->input('content')
            ]);
            return response()->json([
                'status' => '200',
                'Message'=>"Comment updated successfully"
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
    public function destroyComment($id){
        if (auth()->guard('doctor')->check()){

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
