<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Staff;
use App\Visitor;
use App\Traits\ModelInstance;

class StatusController extends Controller
{
    use ModelInstance;
    /**
     * Update status of specified resource .
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $class=$this->getClass($request);
        app($class)::find($id)->toggleStatus();

        return back();
    }
}
