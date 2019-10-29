<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\File;
use App\Traits\ManageFiles;
use App\Traits\ModelInstance;

class FilesController extends Controller
{
    use ManageFiles,ModelInstance;

    /**
     * Store a newly created file in storage.
     *
     * @param  Url of file
     */
    public function store($url,$request)
    {
        $file= File::create(['file'=>$url]);
        if($request->name ||$request->description){
            $file->detail()->create($request->all());
        }
        return $file;
    }
    /**
     * Remove the specified file from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $file=File::find($id);
        $file->delete();
    }
    /**
     * Retrieve stored files using ids of them.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFiles(Request $request)
    {
        $model_object=app($this->getClass($request))::find($request->id);
        $files=$model_object->file;

        return response()->json($files);
    }
    /**
     * Upload file direct to server
     * Create file in storage and store
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadToServer(Request $request)
    {
        $url = $this->UploadFile($request->file('file'), $this->getModelName($request));
        $file=$this->store($url,$request);
        return response()->json(['id' => $file->id,'name'=>$url]);
    }
}
