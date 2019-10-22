<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use App\Traits\ManageFiles;
use DataTables;
use App\Staff;
use App\News;
use App\Enums\NewsType;

class NewsController extends Controller
{
    use ManageFiles;


    public function __construct()
    {
        $this->authorizeResource(News::class);
    }

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
              ->rawColumns(['action']) ->make(true);
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
        $types=NewsType::toSelectArray();
        return view('news.create', compact('relNews', 'types'));
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

        if ($request->input('image')) {
            $news->image()->saveMany($this->getStoredFiles($request));
        }
        if ($request->input('file')) {
            $news->file()->saveMany($this->getStoredFiles($request));
        }
        if ($rel_news = $request['related']) {
            $news->related()->sync($rel_news);
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
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $types=NewsType::toSelectArray();

        $selectedNews =$news->related()->get();
        $selectedNews=$selectedNews->pluck('main_title', 'id')->toArray();

        $authors = $this->returnAuthors($news->staff->job_id);
        
        return view('news.edit', compact('news', 'selectedNews', 'authors', 'types'));
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

        if ($request->input('image')) {
            $news->image()->saveMany($this->getStoredFiles($request));
        }
        if ($request->input('file')) {
            $news->file()->saveMany($this->getStoredFiles($request));
        }
        if ($rel_news = $request['related']) {
            $news->related()->sync($rel_news);
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
        $authors = $this->returnAuthors($request->job_id);
        return response()->json($authors);
    }

    public function returnAuthors($id)
    {
        $authors = Staff::where('job_id', $id)->get();
        $authors=$authors->pluck('user.first_name', 'id');
        return $authors;
    }

    public function getPublishedNews(Request $request)
    {
        $query = $request['search'];
        $news = News::where('is_publish', true)->where('main_title', 'like', "%$query%")
             ->select('main_title', 'id')->get();

        return response()->json($news);
    }
}
