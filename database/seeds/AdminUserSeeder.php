<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::create([
            'name' => 'Admin',
            'description' => 'Administrator',
        ]);

        $user = User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'phone' => '01111111111',
        	'email' => 'admin@gmail.com',
        	'password' => 'Admin12345',
        ]);
  
   
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);
    }
   
}
