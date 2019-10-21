<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\File;
use App\Traits\ManageFiles;


class FilesController extends Controller
{
    use ManageFiles;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($url)
    {
       return File::create(['file'=>$url]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file=File::find($id);
        $file->delete();
    }

    public function getFiles(Request $request)
    {
        $news=News::find($request->news_id);
        $files=$news->file;

        return response()->json($files);
    }
    
    public function uploadToServer(Request $request)
    {
        $url = $this->UploadFile($request->file('file'),'news');
        $file=$this->store($url);
        return response()->json(['id' => $file->id,'name'=>$url]);
    }
}
