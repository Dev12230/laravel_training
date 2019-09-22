<?php
 
use Faker\Generator as Faker;
use App\Country;

$factory->define('App\City', function (Faker $faker) {
    return [
         'city_name'=>$faker->sentence(),

         'Country_id' => Country::all()->random()->id,
      
    ];
});
