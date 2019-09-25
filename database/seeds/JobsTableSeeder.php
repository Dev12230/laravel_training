<?php
use App\Job;
use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::insert([
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
