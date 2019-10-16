<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StaffRequest;
use DataTables;
use Spatie\Permission\Models\Role;
use App\Job;
use App\Country;
use App\City;
use App\User;
use App\Staff;
use Illuminate\Support\Str;
use App\Traits\ManageUploads;
use App\Traits\toggle;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class StaffController extends Controller
{

    use SendsPasswordResetEmails,ManageUploads,toggle;

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
            $staff=Staff::with(['city','job','image']);

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
    public function store(StaffRequest $request)
    {
        $user=User::create(
            array_merge($request->all(), ['password'=> Str::random(8)])
        );
        $user->assignRole($request->role);
        $user->assignRole('staff');

        $staff=$user->staff()->create($request->all());

        if ($image=$request->file('image')) {
            $staff->image()->create(['image'=>$this->UploadImage($image,$staff)]);
        } else {
            $staff->image()->create(['image'=>$this->DefaultImage()]);
        }
  
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
        $cities = City::where("country_id", $staff->country_id)->pluck("city_name", "id");

        return view('staff.edit', compact('staff', 'roles', 'jobs', 'countries', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        $staff->update($request->all());
        $staff->user->update($request->all());
        $staff->user->syncRoles($request->role);
 
        if ($image=$request->file('image')) {
            $staff->image()->update(['image'=>$this->UploadImage($image,$staff)]);
        } else {
            $staff->image()->update(['image'=>$this->DefaultImage()]);
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
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted');
    }

    public function toggleStatus(Staff $staff)
    {
        $this->active($staff->user);
        return redirect()->route('staff.index');
    }
}
