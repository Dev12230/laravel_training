<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use DataTables;
use Spatie\Permission\Models\Role;
use App\SystemJob;
use App\Country;
use App\City;
use App\User;
use App\Staff;
use App\Image;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function getstaff()
    {
        $staff=Staff::with('User')->offset(0)->limit(10);
        return Datatables::of($staff)->setTotalRecords(Staff::count())
           ->addColumn('role', function ($row) {
                 return $row->user->roles->first()->name;
           })
           ->addColumn('image', function ($row) {
                 return '<img src="'.Storage::url($row->image['image']).'" style="height:50px; width:50px;" />';
           })
           ->addColumn('action', function ($data) {
            return  view('staff.actions',compact('data'));

           })->rawColumns(['role','image','action']) ->make(true);

    }
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
        $roles = Role::all()->pluck('name');
        $jobs = SystemJob::all()->pluck('name','id');
        $countries = Country::all()->pluck('name','id');
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
        $user->assignRole($request->role);  
        $staff=Staff::create(['user_id'=>  $user->id,'job_id'=>$request->job_id]);
        
        if($request['image']){
            $this->UploadImage($request['image'],$staff);            
        }
          
        return redirect()->route('staff.index')->with('success', 'User has been Added');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {

        $roles = Role::all()->pluck('name');
        $jobs = SystemJob::all()->pluck('name','id');
        $countries = Country::all()->pluck('name','id');
        return view('staff.edit', compact('staff','roles','jobs','countries','location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        $staff->update($request->only(['job_id']));
        $staff->user->update($request->except('job_id','role_id'));
        $staff->user->syncRoles($request->role); 

        return redirect()->route('staff.index')->with('success', 'Staff has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
       
    }

    public function getCities(Request $request)
    {
        $cities = City::where("country_id",$request->country_id)
            ->pluck("city_name","id");
            return response()->json($cities);
    }

    public function UploadImage($reqImg,$staff){

        $img = $reqImg->store('uploads', 'public'); 

        $image=new Image();
        $image->image= $img;
        $staff->image()->save($image);

    }    
}
