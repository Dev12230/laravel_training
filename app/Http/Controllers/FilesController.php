<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\File;


class FilesController extends Controller
{
    public function getFiles(Request $request)
    {
        $news=News::find($request->news_id);
        $files=$news->file;

        return response()->json($files);
    }
    public function deleteFile($id)
    {
        $file=File::find($id);
        $file->delete();
    }
}
