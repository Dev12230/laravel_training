<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FolderRequest;
use App\Folder;
use App\Staff;
use App\Traits\ManageFiles;
use App\User;
use App\DataTables\FoldersDataTable;

class FoldersController extends Controller
{
    use ManageFiles;

    public function __construct()
    {
        $this->authorizeResource(Folder::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FoldersDataTable $datatable)
    {
        return $datatable->render('folders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('folders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FolderRequest $request)
    {
        $folder=Folder::create($request->all());
        if($request->staff){
            $folder->permitted()->sync($request->staff);
            foreach($folder->permitted()->get() as $staff)
                $staff->user->syncPermissions('folder-crud');
        }  
        return redirect()->route('folders.index')->with('success', 'folder Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Folder $folder)
    {
        $folder= $folder->load(['image', 'file', 'video']);
        return view('folders.show',compact('folder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Folder $folder)
    {
        $folder= $folder->load(['image', 'file', 'video','permitted']);
        return view('folders.edit',compact('folder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FolderRequest $request, Folder $folder)
    {
        $folder->update($request->all());
        $folder->permitted()->sync($request->staff);
            foreach($folder->permitted()->get() as $staff)
                $staff->user->syncPermissions('folder-crud'); 
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        $folder->delete();
        return redirect()->route('folders.index')->with('success', 'folder deleted');
    }

}
