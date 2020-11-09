<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = App\Role::where('name', 'admin')->first();
        $role_member = App\Role::where('name', 'member')->first();
		
        App\User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.pl',
            'password' => bcrypt('admin'),
            'ts_uid' => '',
            'role_id' => $role_admin->id,
        ]);

        App\User::create([
            'name' => 'Guest',
            'email' => 'guest@guest.pl',
            'password' => bcrypt('guest'),
            'ts_uid' => '',
            'role_id' => $role_member->id,
        ]);
    }
}
