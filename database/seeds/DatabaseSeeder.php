<?php
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Country;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(CityTableSeeder::class);


    }
}
