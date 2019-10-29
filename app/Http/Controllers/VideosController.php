<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use App\Detail;
use App\Video;

class VideosController extends Controller
{
    public function uploadVideoForFolder(Folder $folder,Request $request){

        $url = $this->UploadVideo($request->file('video'), 'folder'); 
        if($folder->video){
            $videoFolder=$folder->video()->update(['video'=>$url]);
            $folder->video->detail->update($request->all());
        }else{
            $videoFolder=$folder->video()->create(['video'=>$url]);
            $videoFolder->detail()->create($request->all());
        }
        return response()->json(['name'=>$url]);
    }
}
