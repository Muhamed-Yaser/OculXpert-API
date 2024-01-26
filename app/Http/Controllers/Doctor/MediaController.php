<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function showMedia (){

        if (auth()->guard('doctor')->check()){

            $media = Media::with([
                'user' , 'doctor'
             ])->all();
            return response()->json([
            'status' => '200',
            'Message'=>$media
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
}
