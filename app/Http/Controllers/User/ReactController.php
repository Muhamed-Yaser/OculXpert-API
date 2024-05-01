<?php

namespace App\Http\Controllers\User;

use App\Models\React;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReactController extends Controller
{
    public function addReact(Request $request)
    {

            React::create([
                'doctor_id' => null,
                'user_id' => auth()->guard('user')->user()->id,
                'is_like' => $request->input('is_like'),
                'post_id' => $request->input('post_id'),
            ]);

            return response()->json([
                'status' => '200',
                'Message' => "User reacted successfully"
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

            $react = React::find($id);
            $react->update([
                'is_like' => $request->input('is_like')
            ]);

            return response()->json([
                'status' => '200',
                'Message' => "React updated successfully"
            ]);

    }

    public function destroyReact($id)
    {

            React::findOrFail($id)->delete();

            return response()->json([
                'status' => '200',
                'Message' => "React deleted successfully"
            ]);
    }
}
