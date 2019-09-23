<?php

use App\SystemJobs;
use Illuminate\Database\Seeder;

class SystemJobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemJobs::insert([
            [
                'name' => 'Writer',
                'description' => 'Writter job',
            ],
            [
                'name' => 'Reporter',
                'description' => 'Reporter job',
            ]
        ]);
    }
}
