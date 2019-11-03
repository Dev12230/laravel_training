<?php

namespace App\Http\Controllers;

use App\Traits\ManageFiles;
use App\Http\Requests\MediaRequest;
use App\Folder;
use App\Detail;
use App\Video;
use App\Image;
use App\File;

class FolderUploadController extends Controller
{
    use ManageFiles;

    public function uploadImageForFolder(Folder $folder, MediaRequest $request)
    {
        $url = $this->UploadImage($request->file('image'), 'folder');
        $image=$folder->image()->updateOrCreate(
            ['profile_id'=>$folder->id],
            ['image'=>$url]
        );
        $this->detail($folder, $image, $request);
        return response()->json(['name'=>$url]);
    }

    public function uploadFileForFolder(Folder $folder, MediaRequest $request)
    {
        $url = $this->UploadFile($request->file('file'), 'folder');
        $file=$folder->file()->updateOrCreate(
            ['fileable_id'=>$folder->id],
            ['file'=>$url]
        );
        $this->detail($folder, $file, $request);
        return response()->json(['name'=>$url]);
    }


    public function uploadVideoForFolder(Folder $folder, MediaRequest $request)
    {
        if ($request->file('video_pc')) {
            $url = $this->UploadVideo($request->file('video'), 'folder');
        } elseif ($request->video_youtube) {
            $url = $this->youtubeID($request->video_youtube);
        }
        
        $video=$folder->video()->updateOrCreate(
            ['videoable_id'=>$folder->id],
            ['file'=>$url]
        );
        $this->detail($folder, $video, $request);
        return response()->json(['name'=>$url]);
    }

    public function detail($folder, $file, $request)
    {
        $file->detail()->updateOrCreate(
            ['profile_id'=>$folder->id],
            ['name'=>$request->name,'description'=>$request->description]
        );
    }

    public function youtubeID($url)
    {
        if (strlen($url) > 11) {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
                return $match[1];
            } else {
                return false;
            }
        }
        return $url;
    }
}
