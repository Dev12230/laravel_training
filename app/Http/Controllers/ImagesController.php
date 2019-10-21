<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Event;
use App\Image;
use App\Traits\ManageFiles;

class ImagesController extends Controller
{
    use ManageFiles;

    private $classes;

    public function __construct()
    {
        $this->classes =[
            News::class =>'news',
            Event::class =>'event'
    ];
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
        $model_object=app($this->getClass($request))::find($request->id);
        $images=$model_object->image;

        return response()->json($images);
    }

    public function uploadToServer(Request $request)
    {
        $url = $this->UploadImage($request->file('image'),$this->getModelName($request));
        $image = $this->store($url);
        return response()->json(['id' => $image->id,'name'=>$url]);
    }


    public function getClass($request){
        $class=array_search($this->getModelName($request), $this->classes);
        return $class;
    }

    public function getModelName($request){
        $url=$request->getPathInfo();
        $model_name = explode('/', $url)[1];
        return $model_name;
    }

}
