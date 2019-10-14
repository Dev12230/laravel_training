<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use App\Traits\ManageUploads;
use App\Traits\toggle;
use DataTables;
use App\Staff;
use App\News;


class NewsController extends Controller
{
    use ManageUploads,toggle;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            $news=News::query();
                      
            return Datatables::of($news)       
              ->addColumn('action', function ($row) {
                return  view('news.actions', compact('row'));
               })
               ->addColumn('status', function ($row) {
                return  view('news.status', compact('row'));
               })
               ->rawColumns(['action','status']) ->make(true);
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
        $relNews=News::getPublished();
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

        if ($images = $request->input('image')){
            foreach($images as $image)
                $news->image()->create(['image'=>$image]);
         }

        if($files = $request->input('file')){
            foreach($files as $file)
                $news->file()->create(['file'=>$file]);
         }

         if($rel_news = $request['related']){
            foreach($rel_news as $related)
                $news->related()->create(['related_id' => $related]);
         }

        return redirect()->route('news.index')->with('success', 'News Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return view('news.show',compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $relNews=$news->getPublished();    //get published news
        $selectedNews =$news->related()->get();  //get selected related news 
        $selectedNews=$selectedNews->pluck('news.main_title')->toArray();

        $authors = Staff::where('job_id',$news->staff->job_id)->get();
        $authors=$authors->pluck('user.first_name','id');
        
        return view('news.edit',compact('news','relNews','selectedNews','authors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, News $news)
    {
        $news->update($request->all());

        if ($images = $request->input('image')){
            $news->image()->delete();
            foreach($images as $image)
                $news->image()->create(['image'=>$image]);
         }

        if($files = $request->input('file')){
            $news->file()->delete();
            foreach($files as $file)
                $news->file()->create(['file'=>$file]);
         }
         
        if($rel_news = $request['related']){
            $news->related()->delete();
            foreach($rel_news as $related)
                $news->related()->create(['related_id' => $related]);
         }
         return redirect()->route('news.index')->with('success', 'news has been updated'); 

    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index')->with('success', 'news deleted');
    }

    public function getAuthors(Request $request)
    {
        $authors = Staff::where('job_id',$request->job_id)->get();
        $authors=$authors->pluck('user.first_name','id');

        return response()->json($authors);
    }

    public function toggleStatus(News $news)
    {
        $this->publish($news);
        return redirect()->route('news.index');
    }

    public function uploads(Request $request){
        return $this->serverUpload($request);
    }
}
