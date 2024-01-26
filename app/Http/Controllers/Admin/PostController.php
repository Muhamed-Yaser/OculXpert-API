<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function showPosts (){

        if (auth()->guard('admin')->check()){

            $posts = Post::with([
               'user' , 'doctor'
            ])->get();
            return response()->json([
            'status' => '200',
            'Message'=>$posts
        ]);
        }else
        {
            return response()->json([
                "status" => '401',
                "Message" => 'U are unauthorized'
            ]);
        }
    }
    public function destroypost($id){
        if (auth()->guard('admin')->check()){

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
