<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreStaffRequest;
use DataTables;
use Spatie\Permission\Models\Role;
use App\SystemJob;
use App\Country;
use App\City;
use App\User;
use App\Staff;
use DB;


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        $jobs = SystemJob::get();
        $countries = Country::get();
        return view('staff.create', compact('roles','jobs','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaffRequest $request)
    {
        
        $user=User::create($request->except('job_id','role_id'));
        Staff::create(['user_id'=>  $user->id,'job_id'=>$request->job_id]);
        $user->assignRole($request->role_id);
        return redirect()->route('staff.index')->with('success', 'Staff has been Added');

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

    public function getCities(Request $request)
    {
        $cities = DB::table("cities")
            ->where("country_id",$request->country_id)
            ->pluck("city_name","id");
            return response()->json($cities);
    }
}
