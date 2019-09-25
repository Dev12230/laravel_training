<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use DataTables;
use App\Http\Requests\JobRequest;

class JobsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:job-list');
        $this->middleware('permission:job-create', ['only' => ['create','store']]);
        $this->middleware('permission:job-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:job-delete', ['only' => ['destroy']]);
    }

    public function getJobs(){

        $jobs = Job::offset(0)->limit(10);

        return Datatables::of($jobs)->setTotalRecords(Job::count())
       
            ->addColumn('action', function ($data) {
                return  view('jobs.actions',compact('data'));
            })->rawColumns(['action']) ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jobs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        Job::create($request->all());
        return redirect()->route('jobs.index')->with('success', 'Job has been added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        if( !($job->name === 'Writer' || $job->name === 'Reporter')){
            return view('jobs.edit',compact('job'));
        }
        else{return redirect()->route('Jobs.index')->with('error', 'This Job can not updated');}
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, Job $job)
    {
        $job->fill($request->all())->save();

        return redirect()->route('jobs.index')->with('success', 'Job has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        if( !($job->name === 'Writer' || $job->name === 'Reporter')){
              $job->delete();
              return redirect()->route('jobs.index')->with('success', 'Job has been deleted');
        }
        else {return redirect()->route('jobs.index')->with('error', 'This Job can not deleted');}

    }
}
