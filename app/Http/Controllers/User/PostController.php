<?php
namespace App\Http\Controllers\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    public function addPost (Request $request){


            Post::create([
                'doctor_id' =>$request->doctor_id,
                'user_id' => auth()->guard('user')->user()->id,
                'body'=>$request->input('body')
            ]);
             return response()->json([
                'status' => '200',
                'Message'=>"User posted successfully"
             ]);

    }
    public function showPosts (){



            $posts = Post::with([
                'user' , 'doctor'
             ])->get();
            return response()->json([
            'status' => '200',
            'Message'=>$posts
        ]);

    }
    public function updatePost (Request $request ,$id){

            $post= Post::find($id);
            $post->update([
                'body'=>$request->input('body')
            ]);
            return response()->json([
                'status' => '200',
                'Message'=>"Post updated successfully"
             ]);

    }
    public function destroyPost($id){


           $post=Post::findOrFail($id)->delete();
           return response()->json([
            'status' => '200',
            'Message'=>"Post deleted successfully" ]);

    }
}