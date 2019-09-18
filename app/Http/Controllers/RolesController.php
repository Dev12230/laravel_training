<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RoleRequest;

class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(5);
        
        foreach ($roles as $role) {
            $Permissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $role->id)
            ->join('permissions', 'permissions.id', 'role_has_permissions.permission_id')
            ->get();
  
            $role->permissions= $Permissions;
        }
        return view('roles.index', [
            "roles"=> $roles,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {

        $role=new role([
              'name'=>$request['name'],
             'description'=>$request['description'],
        ]);
        $role->save();
        $role->syncPermissions($request['permission']);

        return redirect()->route('roles.index')->with('success', 'Role has been updated');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")
        ->where("role_has_permissions.role_id", $role->id)
        ->join('permissions', 'permissions.id', 'role_has_permissions.permission_id')
        ->pluck('name', 'name')
        ->all();


        return view('roles.edit', [
            'permissions' =>$permissions,
            'role'=>$role,
            'rolePermissions'=>$rolePermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {

        $role->name = $request['name'];
        $role->description = $request['description'];
        $role->save();
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
