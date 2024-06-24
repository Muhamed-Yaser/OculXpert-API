<?php

namespace App\Http\Controllers\User;
use App\Models\React;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReactController extends Controller
{
    public function addReact(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'post_id' => 'required|integer',
            'is_like' => 'required|boolean',
        ]);

        $email = $request->input('email');
        $postId = $request->input('post_id');
        $doctorId = $this->getDoctorIdByEmail($email);
        $userId = $this->getUserIdByEmail($email);

        if ($doctorId !== null) {
            $existingReact = React::where('doctor_id', $doctorId)->where('post_id', $postId)->first();

            if ($existingReact) {
                return response()->json([
                    'status' => '400',
                    'Message' => "Doctor has already reacted to this post"
                ]);
            }

            React::create([
                'user_id' => null,
                'doctor_id' => $doctorId,
                'is_like' => $request->input('is_like'),
                'post_id' => $postId
            ]);

            $message = "Doctor reacted successfully";
        } elseif ($userId !== null) {
            $existingReact = React::where('user_id', $userId)->where('post_id', $postId)->first();

            if ($existingReact) {
                return response()->json([
                    'status' => '400',
                    'Message' => "User has already reacted to this post"
                ]);
            }

            React::create([
                'user_id' => $userId,
                'doctor_id' => null,
                'is_like' => $request->input('is_like'),
                'post_id' => $postId
            ]);

            $message = "User reacted successfully";
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

    public function showReacts()
    {
        $reacts = React::with(['user', 'doctor'])->get();

        return response()->json([
            'status' => '200',
            'Message' => $reacts
        ]);
    }

    public function updateReact(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'is_like' => 'required|boolean',
        ]);

        $email = $request->input('email');
        $isLike = $request->input('is_like');
        $doctorId = $this->getDoctorIdByEmail($email);
        $userId = $this->getUserIdByEmail($email);

        $react = React::find($id);

        if (($doctorId !== null && $react->doctor_id == $doctorId) ||
            ($userId !== null && $react->user_id == $userId)) {
            $react->update(['is_like' => $isLike]);

            return response()->json([
                'status' => '200',
                'Message' => "React updated successfully"
            ]);
        }

        return response()->json([
            'status' => '403',
            'Message' => "You are not authorized to update this react"
        ]);
    }

    public function destroyReact(Request $request, $id)
    {
        $email = $request->input('email');
        $doctorId = $this->getDoctorIdByEmail($email);
        $userId = $this->getUserIdByEmail($email);

        $react = React::findOrFail($id);

        if (($doctorId !== null && $react->doctor_id == $doctorId) ||
            ($userId !== null && $react->user_id == $userId)) {
            $react->delete();

            return response()->json([
                'status' => '200',
                'Message' => "React deleted successfully"
            ]);
        }

        return response()->json([
            'status' => '403',
            'Message' => "You are not authorized to delete this react"
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
