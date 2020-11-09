<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'pending',
            'accepted',
            'rejected'
        ];

        foreach($statuses as $status)
        {
            $s = new App\Status();
            $s->name = $status;
            $s->save();
        }
    }
}
