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
use App\Traits\ImageUpload;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class StaffController extends Controller
{

    use SendsPasswordResetEmails,ImageUpload;

    public function __construct()
    {
        $this->authorizeResource(Staff::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $staff=Staff::with(['job','image']);
   
            return Datatables::of($staff)
               ->addColumn('role', function ($row) {
                return $row->user->getRoleNames()->first();
               })
               ->addColumn('action', function ($row) {
                return  view('staff.actions', compact('row'));
               })
               ->addColumn('status', function ($row) {
                return  view('staff.status', compact('row'));
               })->rawColumns(['role','action','status']) ->make(true);
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
        $roles = Role::pluck('name');
        $jobs = Job::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        return view('staff.create', compact('roles', 'jobs', 'countries'));
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
            array_merge($request->all(), ['password'=> Str::random(8)])
        );
        $user->assignRole($request->role);

        $staff=Staff::create(
            array_merge($request->all(), ['user_id' => $user->id])
        );

        $this->UploadImage($request,$staff);
  
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
        $roles = Role::pluck('name');
        $jobs = Job::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        return view('staff.edit', compact('staff', 'roles', 'jobs', 'countries'));
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
        $staff->user->update($request->all());
        $staff->user->syncRoles($request->role);
 
        $this->UploadImage($request,$staff);

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
        $staff->user()->delete();
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted');
    }

    public function getCities(Request $request)
    {
        $cities = City::where("country_id", $request->country_id)
            ->pluck("city_name", "id");
         return response()->json($cities);
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
