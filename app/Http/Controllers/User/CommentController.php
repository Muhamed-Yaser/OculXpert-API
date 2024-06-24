<?php
namespace App\Http\Controllers\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'content' => 'required|string',
            'post_id' => 'required|integer',
        ]);

        $email = $request->input('email');
        $content = $request->input('content');
        $postId = $request->input('post_id');
        $doctorId = $this->getDoctorIdByEmail($email);
        $userId = $this->getUserIdByEmail($email);

        if ($doctorId !== null) {
            Comment::create([
                'doctor_id' => $doctorId,
                'user_id' => null,
                'content' => $content,
                'post_id' => $postId,
            ]);

            $message = "Doctor commented successfully";
        } elseif ($userId !== null) {
            Comment::create([
                'doctor_id' => null,
                'user_id' => $userId,
                'content' => $content,
                'post_id' => $postId,
            ]);

            $message = "User commented successfully";
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

    public function showComments()
    {
        $comments = Comment::with(['user', 'doctor'])->get();

        return response()->json([
            'status' => '200',
            'Message' => $comments
        ]);
    }

    public function updateComment(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'content' => 'required|string',
        ]);

        $email = $request->input('email');
        $content = $request->input('content');
        $doctorId = $this->getDoctorIdByEmail($email);
        $userId = $this->getUserIdByEmail($email);

        $comment = Comment::find($id);

        if (($doctorId !== null && $comment->doctor_id == $doctorId) ||
            ($userId !== null && $comment->user_id == $userId)) {
            $comment->update(['content' => $content]);

            return response()->json([
                'status' => '200',
                'Message' => "Comment updated successfully"
            ]);
        }

        return response()->json([
            'status' => '403',
            'Message' => "You are not authorized to update this comment"
        ]);
    }

    public function destroyComment(Request $request, $id)
    {
        $email = $request->input('email');
        $doctorId = $this->getDoctorIdByEmail($email);
        $userId = $this->getUserIdByEmail($email);

        $comment = Comment::findOrFail($id);

        if (($doctorId !== null && $comment->doctor_id == $doctorId) ||
            ($userId !== null && $comment->user_id == $userId)) {
            $comment->delete();

            return response()->json([
                'status' => '200',
                'Message' => "Comment deleted successfully"
            ]);
        }

        return response()->json([
            'status' => '403',
            'Message' => "You are not authorized to delete this comment"
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
