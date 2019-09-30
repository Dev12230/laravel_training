<?php

namespace App\Http\Controllers;

use DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;


class RolesController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $roles = Role::with('permissions')->offset(0)->limit(10);
        
            return Datatables::of($roles)->setTotalRecords(Role::count())
            
                ->addColumn('action', function ($row) {
                    return  view('roles.actions',compact('row'));
                })->rawColumns(['action']) ->make(true);
        }

        return view('roles.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $permissions = Permission::pluck('name','id');
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {

        Role::create($request->only(['name', 'description']))
          ->syncPermissions($request['permission']);

        return redirect()->route('roles.index')->with('success', 'Role has been created');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::pluck('name','id');
        $rolePermissions=$role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('permissions', 'role', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {

        $role->update($request->only(['name', 'description']));
        $role->syncPermissions($request['permission']);
        return redirect()->route('roles.index')->with('success', 'Role has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    { 

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role has been deleted');
    }
}
