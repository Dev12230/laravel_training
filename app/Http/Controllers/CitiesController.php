<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Country;
use App\City;
use App\Http\Requests\CityRequest;


class CitiesController extends Controller
{

    public function cities_list()
    {
        $cities = City::with('Country');
        return datatables()->of($cities)->toJson();
    }

    public function  index(){
       return view('cities.index');
    }

    public function  create(){
        $countries=Country::all();
        return view('cities.create',[
            'countries'=>$countries
        ]);
    }


    public function  store(CityRequest $request){

        $City = new City($request->all());
        $City->save();
        return redirect()->route('cities.index')->with('success', 'City has been updated');

  }

  public function edit(City $city)
    {
 
        $countries=Country::all();
        return view('cities.edit',[
            'countries'=>$countries,
            'city'=>$city
        ]);
 
    }

  public function update(City $city,CityRequest $request)
    {


        $city->fill($request->all())->save();

        return redirect()->route('cities.index')->with('success', 'City has been updated');



    } 

 public function delete(City $city)
    {

        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City has been deleted');
    }   
      


}
