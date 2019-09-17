<?php
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateVisitorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'visitor',
            'last_name' => 'visitor',
            'email' => 'visitor@gmail.com',
            'phone' => '01222222222',
            'password' => 'Rr123456'
        ]);
        $role = Role::create(['name' => 'Visitor', 'description' => 'description']);

        $role->givePermissionTo(['role-list','city-list']);
        $user->assignRole([$role->id]);
    }
}
