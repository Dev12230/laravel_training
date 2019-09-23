<?php
 
use Faker\Generator as Faker;


$factory->define('App\SystemJobs', function (Faker $faker) {
    return [
         'name'=>$faker->name,
         'description'=>$faker->sentence(),
      
    ];
});
