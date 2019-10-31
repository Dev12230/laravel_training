<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'city-list',
            'city-create',
            'city-edit',
            'city-delete',

            'job-list',
            'job-create',
            'job-edit',
            'job-delete',

            'staff-list',
            'staff-create',
            'staff-edit',
            'staff-delete',
            'staff-active',
            
            'visitor-list',
            'visitor-create',
            'visitor-edit',
            'visitor-delete',
            'visitor-active',

            'news-list',
            'news-show',
            'news-create',
            'news-edit',
            'news-delete',
            'news-active',

            'folder-crud',
           
         ];
 
 
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }

         Role::findByName('Admin')->syncPermissions($permissions);
    }
}
