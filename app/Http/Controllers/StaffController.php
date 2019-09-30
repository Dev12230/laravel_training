<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use DataTables;
use Spatie\Permission\Models\Role;
use App\Job;
use App\Country;
use App\City;
use App\User;
use App\Staff;
use App\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;


class StaffController extends Controller
{

    use SendsPasswordResetEmails;

    public function getStaff(){
        $staff=Staff::with('job');
   
        return Datatables::of($staff)
           ->addColumn('role', function ($row) {
                     return $row->user->getRoleNames()->first();
           })
           ->addColumn('action', function ($row) {
            return  view('staff.actions',compact('row'));
           })
           ->addColumn('status', function ($row) {
            return  view('staff.status',compact('row'));
            
           })->rawColumns(['role','image','action','status']) ->make(true);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Staff::class);

        if ($request->ajax()) {
            $staff=Staff::with(['job','image']);
   
            return Datatables::of($staff)
               ->addColumn('role', function ($row) {
                         return $row->user->getRoleNames()->first();
               })
            //    ->addColumn('image', function ($row) {
            //          return '<img src="'.Storage::url($row->image['image']).'" style="height:50px; width:50px;" />';
            //    })
               ->addColumn('action', function ($row) {
                return  view('staff.actions',compact('row'));
    
               })
               ->addColumn('status', function ($row) {
                return  view('staff.status',compact('row'));
    
               })->rawColumns(['role','image','action','status']) ->make(true);

        }
         return view('staff.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Staff::class);

        $roles = Role::pluck('name');
        $jobs = Job::pluck('name','id');
        $countries = Country::pluck('name','id');
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
        $user=User::create(
            $request->except('password') + ['password' => Str::random(8)]
        );
        $user->assignRole($request->role);  

        $staff=Staff::create($request->except('user_id') + ['user_id' => $user->id]);
        
        //image upload
        if($request['image']){
            $img=$this->UploadImage($request['image']); 
            
        }else{
            $img=Image::defaultImage();
        }
        $staff->image()->create(['image'=> $img]); 

        $this->sendResetLinkEmail($request);         
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
        $this->authorize('update', $staff);
        $roles = Role::pluck('name');
        $jobs = Job::pluck('name','id');
        $countries = Country::pluck('name','id');
        return view('staff.edit', compact('staff','roles','jobs','countries'));
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
        $this->authorize('update', $staff);

        $staff->update($request->only(['job_id']));
        $staff->user->update($request->all());
        $staff->user->syncRoles($request->role); 

          if ($request->has('image')) {
            $img=$this->UploadImage(request('image'));
            $staff->image()->Update(['image'=>$img]);
          }

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
        $this->authorize('delete', $staff);

        $staff->user->delete();
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted');
       
    }

    public function getCities(Request $request)
    {
        $cities = City::where("country_id",$request->country_id)
            ->pluck("city_name","id");
         return response()->json($cities);
    }

    public function UploadImage($reqImg){

        $img = $reqImg->store('uploads', 'public');
        return $img;

    }    

    public function deActive(Staff $staff)
    {
        $this->authorize('active', $staff);
        $staff->user->ban();
        return redirect()->route('staff.index');
    }

    public function active(Staff $staff)
    {
        $this->authorize('active', $staff);
        $staff->user->unban();
        return redirect()->route('staff.index');
    }
}
