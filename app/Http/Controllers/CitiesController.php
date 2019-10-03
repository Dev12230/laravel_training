<?php

namespace App\Http\Controllers;

use App\Country;
use App\City;
use App\Http\Requests\CityRequest;
use DataTables;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(City::class);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cities = City::with('Country');

            return Datatables::of($cities)
            ->addColumn('action', function ($row) {
                return  view('cities.actions', compact('row'));
            })->rawColumns(['action']) ->make(true);
        }
        return view('cities.index');
    }

    public function create()
    {
        $countries=Country::pluck('name', 'id');
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
        $countries=Country::pluck('name', 'id');
        return view('cities.edit', [
            'countries'=>$countries,
            'city'=>$city
        ]);
    }

    public function update(City $city, CityRequest $request)
    {
        $city->update($request->all());

        return redirect()->route('cities.index')->with('success', 'City has been updated');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City has been deleted');
    }

    public function getCities(Request $request)
    {
        $cities = City::where("country_id", $request->country_id)
            ->pluck("city_name", "id");
         return response()->json($cities);
    }
}
