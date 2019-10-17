<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Image;
use App\Traits\ManageUploads;

class ImagesController extends Controller
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
        return Image::create(['image'=>$url]);
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
        $image=Image::find($id);
        $image->delete();
    }

    public function getImages(Request $request)
    {
        $news=News::find($request->news_id);
        $images=$news->image;

        return response()->json($images);
    }

    public function uploadToServer(Request $request)
    {
        $url = $this->UploadImage($request->file('image'),'news');
        $image = $this->store($url);
        return response()->json(['id' => $image->id,'name'=>$url]);
    }

}
