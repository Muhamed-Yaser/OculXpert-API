<?php

namespace App\Http\Controllers\Doctor;

use App\Models\React;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReactController extends Controller
{
    public function addReact(Request $request)
    {
        if (auth()->guard('doctor')->check()) {
            React::create([
                'user_id' => null,
                'doctor_id' => auth()->guard('doctor')->user()->id,
                'is_like' => $request->input('is_like'),
                'post_id' => $request->input('post_id'),
            ]);

            return response()->json([
                'status' => '200',
                'Message' => "Doctor reacted successfully"
            ]);
        } else {
            return response()->json([
                "status" => '401',
                "Message" => 'You are unauthorized'
            ]);
        }
    }

    public function showReacts()
    {
        if (auth()->guard('doctor')->check()) {
            $reacts = React::with(['user', 'doctor'])->get();

            return response()->json([
                'status' => '200',
                'Message' => $reacts
            ]);
        } else {
            return response()->json([
                "status" => '401',
                "Message" => 'You are unauthorized'
            ]);
        }
    }

    public function updateReact(Request $request, $id)
    {
        if (auth()->guard('doctor')->check()) {
            $react = React::find($id);
            $react->update([
                'is_like' => $request->input('is_like')
            ]);

            return response()->json([
                'status' => '200',
                'Message' => "React updated successfully"
            ]);
        } else {
            return response()->json([
                "status" => '401',
                "Message" => 'You are unauthorized'
            ]);
        }
    }

    public function destroyReact($id)
    {
        if (auth()->guard('doctor')->check()) {
            React::findOrFail($id)->delete();

            return response()->json([
                'status' => '200',
                'Message' => "React deleted successfully"
            ]);
        } else {
            return response()->json([
                "status" => '401',
                "Message" => 'You are unauthorized'
            ]);
        }
    }
}
