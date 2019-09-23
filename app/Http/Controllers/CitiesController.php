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
        $this->middleware('auth');
        $this->middleware('permission:city-list');
        $this->middleware('permission:city-create', ['only' => ['create','store']]);
        $this->middleware('permission:city-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:city-delete', ['only' => ['index','destroy']]);
    }

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
        return view('cities.index');
    }

    public function create()
    {
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
 
        $countries=Country::all();
        return view('cities.edit', [
            'countries'=>$countries,
            'city'=>$city
        ]);
    }

    public function update(City $city, CityRequest $request)
    {


        $city->fill($request->all())->save();

        return redirect()->route('cities.index')->with('success', 'City has been updated');
    }

    public function destroy(City $city)
    {

        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City has been deleted');
    }
}
