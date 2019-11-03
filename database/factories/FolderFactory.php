<?php
 
use Faker\Generator as Faker;

$factory->define('App\Folder', function (Faker $faker) {
    return [
         'name'=>$faker->name(),
         'description' => $faker->paragraph(),
    ];
});
