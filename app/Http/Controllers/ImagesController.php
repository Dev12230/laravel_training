<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Image;

class ImagesController extends Controller
{
    public function getImages(Request $request)
    {
        $news=News::find($request->news_id);
        $images=$news->image;

        return response()->json($images);
    }

    public function destroy($id)
    {
        $image=Image::find($id);
        $image->delete();
    }
}
