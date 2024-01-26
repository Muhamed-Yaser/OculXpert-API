<?php
namespace App\Http\Controllers\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    public function addPost (Request $request){

        if (auth()->guard('user')->check()){
            Post::create([
                'doctor_id' =>$request->doctor_id,
                'user_id' => auth()->guard('user')->user()->id??'No posts yet',
                'body'=>$request->input('body')
            ]);
             return response()->json([
                'status' => '200',
                'Message'=>"User posted successfully"
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
    public function showPosts (){

        if (auth()->guard('user')->check()){

            $posts = Post::with([
                'user' , 'doctor'
             ])->get();
            return response()->json([
            'status' => '200',
            'Message'=>$posts
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
    public function updatePost (Request $request ,$id){
        if (auth()->guard('user')->check()){
            $post= Post::find($id);
            $post->update([
                'body'=>$request->input('body')
            ]);
            return response()->json([
                'status' => '200',
                'Message'=>"Post updated successfully"
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
    public function destroyPost($id){
        if (auth()->guard('user')->check()){

           $post=Post::findOrFail($id)->delete();
           return response()->json([
            'status' => '200',
            'Message'=>"Post deleted successfully" ]);
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
