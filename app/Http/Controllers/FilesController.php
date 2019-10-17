<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\File;
use App\Traits\ManageUploads;


class FilesController extends Controller
{
    use ManageUploads;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
