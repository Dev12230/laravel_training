<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemJobs;
use DataTables;
use App\Http\Requests\JobRequest;

class JobsController extends Controller
{
    public function getjobs(){
        $totalData = SystemJobs::count();
        $jobs = SystemJobs::offset(0)->limit(10);

        return Datatables::of($jobs)->setTotalRecords($totalData)
        ->addColumn('action', function ($row) {
            $JobId=$row->id;
            $JobName=$row->name;
            return  view('jobs.actions',compact('JobId','JobName'));
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
        SystemJobs::create($request->all());
        return redirect()->route('jobs.index')->with('success', 'Job has been added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemJobs $job)
    {
        if( !($job->name === 'Writer' || $job->name === 'Reporter')){
            return view('jobs.edit',[
                'job' =>$job ,
             ]);
        }
        else{return redirect()->route('jobs.index')->with('error', 'This job can not updated');}
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, SystemJobs $job)
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
    public function destroy(SystemJobs $job)
    {
        if( !($job->name === 'Writer' || $job->name === 'Reporter')){
              $job->delete();
              return redirect()->route('jobs.index')->with('success', 'Job has been deleted');
        }
        else {return redirect()->route('jobs.index')->with('error', 'This job can not deleted');}

    }
}
