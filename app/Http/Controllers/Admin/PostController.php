<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function showPosts (){



            $posts = Post::with([
               'user' , 'doctor'
            ])->get();
            return response()->json([
            'status' => '200',
            'Message'=>$posts
        ]);

    }
    public function destroypost($id){


           $post=Post::findOrFail($id)->delete();
           return response()->json([
            'status' => '200',
            'Message'=>"Post deleted successfully" ]);
    }
}