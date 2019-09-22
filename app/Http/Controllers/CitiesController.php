<?php

namespace App\Http\Controllers;

use App\Country;
use App\City;
use App\Http\Requests\CityRequest;
use DataTables;
use Illuminate\Http\Request;

class CitiesController extends Controller
{


    public function cities_list()
    {
       
       $totalData = City::count();
       $cities = City::with('Country')->offset(0)->limit(10);

       return Datatables::of($cities)->setTotalRecords($totalData)->make(true);
                    
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
