<?php

namespace App\Http\Controllers;

use App\Traits\ManageFiles;
use App\Http\Requests\MediaRequest;
use App\Folder;
use App\Detail;
use App\Video;

class VideosController extends Controller
{
    use ManageFiles;

    public function uploadVideoForFolder(Folder $folder,MediaRequest $request){

        if($request->file('video_pc')){
            $url = $this->UploadVideo($request->file('video'), 'folder'); 
        }elseif($request->video_youtube){
            $url = $this->youtubeID($request->video_youtube);
        }

        if($folder->video){
            $videoFolder=$folder->video()->update(['video'=>$url]);
            $folder->video->detail->update($request->all());
        }else{
            $videoFolder=$folder->video()->create(['video'=>$url]);
            $videoFolder->detail()->create($request->all());
        }
        return response()->json(['name'=>$url]);
    }


    function youtubeID($url)
    {
        if(strlen($url) > 11){
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)){
                return $match[1];
            }else{
                return false;
            }
        }
        return $url;
    }
}
