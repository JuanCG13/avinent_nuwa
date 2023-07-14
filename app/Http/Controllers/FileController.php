<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

class FileController extends Controller
{
    public function fileUpload(Request $request){
        $filename = null;
        foreach ($request->files as $file){
                $filename = random_int(10000000, 99999999) . '.' . $file->getClientOriginalExtension();
                Storage::disk('tmp')->put($filename, File::get($file));
        }
      
       return back()->with('uploadedFile', $filename);
    }
  
      public function getFile(Request $request, $filename){ 
        $file_path = Storage::disk('tmp')->path($filename);
        $file = File::get($file_path);
        $type = File::mimeType($file_path);
        $response = Response::stream(function() use ($file)
        {
            echo $file;
        }, 200, ["Content-Type" => $type]);
        return $response;
    }

   }
