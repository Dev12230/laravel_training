<?php

use Illuminate\Database\Seeder;
use App\User;


class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'phone' => '01111111111',
        	'email' => 'admin@gmail.com',
        	'password' => 'Admin12345',
        ]);
  
        $user->assignRole('Admin');
    }
   
}
