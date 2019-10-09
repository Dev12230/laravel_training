<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use App\Traits\ManageUploads;
use DataTables;
use App\Staff;
use App\News;


class NewsController extends Controller
{
    use ManageUploads;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $news=News::query();
            
            return Datatables::of($news)       
              ->addColumn('action', function ($row) {
                return  view('news.actions', compact('row'));
               })
               ->addColumn('status', function ($row) {
                return  view('news.status', compact('row'));
               })->rawColumns(['action','status']) ->make(true);
         }
        return view('news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $relNews=News::where('is_publish',1)->pluck("main_title", "id");
        return view('news.create',compact('relNews'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $news=News::create($request->all());

        if ($images = $request->file('image')){
            foreach($images as $image)
                $this->UploadImage($request,$news,$image);
         }

        if($files = $request->file('file')){
            foreach($files as $file)
                $this->UploadFile($request,$news,$file);
         }

         if($rel_news = $request['related']){
            foreach($rel_news as $related)
                $news->related()->create([
                    'news_id' => $news->id,
                    'related_id' => $related,
                ]);
         }
         
        return redirect()->route('news.index')->with('success', 'News Added');
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
        //
    }

    public function getAuthors(Request $request)
    {
        $authors = Staff::with('User')->where('job_id',$request->job_id)->get();
        $authors=$authors->pluck('user.first_name','user.id');

        return response()->json($authors);
    }

    public function toggleStatus(News $news)
    {
        $news->is_publish = !$news->is_publish;
        $news->update();
        return redirect()->route('news.index');
    }
}
