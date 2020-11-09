<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'member'
        ];

        foreach($roles as $role)
        {
            $r = new App\Role();
            $r->name = $role;
            $r->save();
        }

    }
}
