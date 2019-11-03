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

    public function store(Folder $folder, MediaRequest $request)
    {
        $request->video_youtube ?
            $url = $this->youtubeID($request->video_youtube):
            $url = $this->Upload($request, 'folder');

        if ($request->file('image')) {
            $file=$folder->image()->updateOrCreate(
                ['profile_id'=>$folder->id],
                ['image'=>$url]
            );
        } elseif ($request->file('file')) {
            $file=$folder->file()->updateOrCreate(
                ['fileable_id'=>$folder->id],
                ['file'=>$url]
            );
        } elseif ($request->video_pc || $request->video_youtube) {
            $file=$folder->video()->updateOrCreate(
                ['videoable_id'=>$folder->id],
                ['video'=>$url]
            );
        }
            $this->detail($folder, $file, $request);
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
