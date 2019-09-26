<?php

namespace App\Http\Controllers;

use App\Country;
use App\City;
use App\Http\Requests\CityRequest;
use DataTables;
use Illuminate\Http\Request;


class CitiesController extends Controller
{

    public function getCities(Request $request)
    {

        $cities = City::with('Country')->offset(0)->limit(10);

        return Datatables::of($cities)->setTotalRecords(City::count())
        
            ->addColumn('action', function ($data) {
                return  view('cities.actions',compact('data'));
            })->rawColumns(['action']) ->make(true);
    }


    public function index()
    {
        $this->authorize('viewAny', City::class);
        return view('cities.index');
    }

    public function create()
    {
        $this->authorize('create', City::class);
        $countries=Country::all();
        return view('cities.create', [
            'countries'=>$countries
        ]);
    }


    public function store(CityRequest $request)
    {

        $City = new City($request->all());
        $City->save();
        return redirect()->route('cities.index')->with('success', 'City has been updated');
    }

    public function edit(City $city)
    {
        $this->authorize('update', $city);
        
        $countries=Country::all();
        return view('cities.edit', [
            'countries'=>$countries,
            'city'=>$city
        ]);
    }

    public function update(City $city, CityRequest $request)
    {
        $this->authorize('update', $city);
        $city->fill($request->all())->save();

        return redirect()->route('cities.index')->with('success', 'City has been updated');
    }

    public function destroy(City $city)
    {
        $this->authorize('delete', $city);
        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City has been deleted');
    }
}
