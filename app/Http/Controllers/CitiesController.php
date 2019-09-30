<?php

namespace App\Http\Controllers;

use App\Country;
use App\City;
use App\Http\Requests\CityRequest;
use DataTables;
use Illuminate\Http\Request;



class CitiesController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('viewAny', City::class);

        
        if ($request->ajax()) {

        $cities = City::query();

        return Datatables::of($cities)
            ->addColumn('action', function ($row) {
                return  view('cities.actions',compact('row'));
            })->rawColumns(['action']) ->make(true);
        }
        return view('cities.index');
    }

    public function create()
    {
        $this->authorize('create', City::class);

        $countries=Country::pluck('name','id');
        return view('cities.create', [
            'countries'=>$countries
        ]);
    }


    public function store(CityRequest $request)
    {

        City::create($request->all());
        return redirect()->route('cities.index')->with('success', 'City has been updated');
    }

    public function edit(City $city)
    {
        $this->authorize('update', $city);
        
        $countries=Country::pluck('name','id');
        return view('cities.edit', [
            'countries'=>$countries,
            'city'=>$city
        ]);
    }

    public function update(City $city, CityRequest $request)
    {
        $this->authorize('update', $city);
        $city->update($request->all());

        return redirect()->route('cities.index')->with('success', 'City has been updated');
    }

    public function destroy(City $city)
    {
        $this->authorize('delete', $city);
        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City has been deleted');
    }
}
