<?php
namespace App\Http\Controllers\Doctor;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    public function addPost (Request $request){

        if (auth()->guard('doctor')->check()){
            Post::create([
                'user_id' => null,
                'doctor_id' => auth()->guard('doctor')->user()->id??'No posts yet',
                'body'=>$request->input('body')
            ]);
             return response()->json([
                'status' => '200',
                'Message'=>"Doctor posted successfully"
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

        if (auth()->guard('doctor')->check()){

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
        if (auth()->guard('doctor')->check()){
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
        if (auth()->guard('doctor')->check()){

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
