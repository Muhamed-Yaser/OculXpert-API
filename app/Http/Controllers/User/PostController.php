<?php
namespace App\Http\Controllers\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function addPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'body' => 'required|string',
        ]);

        $email = $request->input('email');
        $body = $request->input('body');
        $doctorId = $this->getDoctorIdByEmail($email);
        $userId = $this->getUserIdByEmail($email);

        if ($doctorId !== null) {
            Post::create([
                'doctor_id' => $doctorId,
                'user_id' => null,
                'body' => $body,
            ]);

            $message = "Doctor posted successfully";
        } elseif ($userId !== null) {
            Post::create([
                'doctor_id' => null,
                'user_id' => $userId,
                'body' => $body,
            ]);

            $message = "User posted successfully";
        } else {
            return response()->json([
                'status' => '400',
                'Message' => "Invalid email. The email must belong to either a doctor or a user."
            ]);
        }

        return response()->json([
            'status' => '200',
            'Message' => $message
        ]);
    }

    public function showPosts()
    {
        $posts = Post::with(['user', 'doctor'])->get();

        return response()->json([
            'status' => '200',
            'Message' => $posts
        ]);
    }

    public function updatePost(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'body' => 'required|string',
        ]);

        $email = $request->input('email');
        $body = $request->input('body');
        $doctorId = $this->getDoctorIdByEmail($email);
        $userId = $this->getUserIdByEmail($email);

        $post = Post::find($id);

        if (($doctorId !== null && $post->doctor_id == $doctorId) ||
            ($userId !== null && $post->user_id == $userId)) {
            $post->update(['body' => $body]);

            return response()->json([
                'status' => '200',
                'Message' => "Post updated successfully"
            ]);
        }

        return response()->json([
            'status' => '403',
            'Message' => "You are not authorized to update this post"
        ]);
    }

    public function destroyPost(Request $request, $id)
    {
        $email = $request->input('email');
        $doctorId = $this->getDoctorIdByEmail($email);
        $userId = $this->getUserIdByEmail($email);

        $post = Post::findOrFail($id);

        if (($doctorId !== null && $post->doctor_id == $doctorId) ||
            ($userId !== null && $post->user_id == $userId)) {
            $post->delete();

            return response()->json([
                'status' => '200',
                'Message' => "Post deleted successfully"
            ]);
        }

        return response()->json([
            'status' => '403',
            'Message' => "You are not authorized to delete this post"
        ]);
    }

    private function getDoctorIdByEmail($email)
    {
        $doctor = \App\Models\Doctor::where('email', $email)->first();
        return $doctor ? $doctor->id : null;
    }

    private function getUserIdByEmail($email)
    {
        $user = \App\Models\User::where('email', $email)->first();
        return $user ? $user->id : null;
    }
}
