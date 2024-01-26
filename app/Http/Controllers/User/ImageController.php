<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Media;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\ServiceException;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
     public function uploadImage(Request $req){
        if (auth()->guard('user')->check()){
        // $req->validate([
        // 'file' => 'required|mimes:jpg,csv,txt,xlx,xls,pdf|max:2048'
        // ]);

        if($req->file()) {
            $fileName = time().'_'.$req->file->getClientOriginalName();

            $filePath = $req->file('file')->storeAs('uploads/', $fileName, 'azure');
        }
        return response()->json([
            'status' => '200',
            'Message'=>"Image uploaded successfully"
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





//stackOverFlow
// public function fileUpload(Request $req){
//     $req->validate([
//     'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
//     ]);



//     if($req->file()) {
//         $fileName = time().'_'.$req->file->getClientOriginalName();

//         $filePath = $req->file('file')->storeAs('uploads/', $fileName, 'azure');

//         return back()
//         ->with('success','File has been uploaded.')

//     }
// }
