<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\File;

class FileController extends Controller
{
    public function upload(Request $request,$task_id,$variant_id ){//загрузить
        try {
            $file = $request->file('file');

            if (!$file) {
                return response()->json('no file');
            }

            $userId = Auth::user()->id;
            $fileName = md5($file->getClientOriginalName() . microtime());/////////
            $fileExt = $file->getClientOriginalExtension();
            $fileUrl = 'usersfiles/' . $userId . '/' . $fileName . '.' . $fileExt;

            Storage::put($fileUrl, file_get_contents($file));


            $fileModel = new File();
            $fileModel->file_name = $request->name ? $request->name . '.' . $file->getClientOriginalExtension() : $file->getClientOriginalName();
            $fileModel->url = $fileUrl;
            $fileModel->extension = $fileExt;
            $fileModel->task_id=$task_id;
            $fileModel->variant_id=$variant_id;
            $fileModel->user_id = $userId;
            $fileModel->file_size = $file->getClientSize();
            $fileModel->content_type = $file->getClientMimeType();

            $fileModel->hash = $fileName;


            $fileModel->save();

            return response()->json($fileModel, 200);

        }
        catch(\Exception $exception){
            return response()->json(['message exception' => $exception->getMessage()], 401);
        }


    }

    public function download($id,$variant_id)//скачать
    {
        try {
            $file = File::select('id', 'file_name', 'url','extension','task_id','variant_id', 'user_id', 'file_size', 'content_type','hash')->where(['variant_id'=>$variant_id])->where(['task_id' => $id])->first();


            $filePath = storage_path('app/' . $file->url);

            return response()->json(['file' => base64_encode(file_get_contents($filePath)), 'file_name' => $file->file_name], 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Файл не найден, либо у вас нет прав'], 401);
        }
    }
}

