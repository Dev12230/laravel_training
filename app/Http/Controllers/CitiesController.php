<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Country;
use App\City;


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


    public function  store(Request $request){

        $request->validate([
            //Unique  based on city_name and country_id
            'city_name'=>'required|max:150|unique:cities,city_name,NULL,id,country_id,'.$request->country_id,
            'country_id' => 'required',
        ]);

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

  public function update(City $city,Request $request)
    {
        $request->validate([
            'city_name'=>'required|max:150|unique:cities,city_name,NULL,id,country_id,'.$request->country_id,
            'country_id' => 'required',
        ]);

        $city->fill($request->all())->save();

        return redirect()->route('cities.index')->with('success', 'City has been updated');



    } 

 public function delete(City $city)
    {

        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City has been deleted');
    }   
      


}
