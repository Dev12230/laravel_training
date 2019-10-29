<?php

use Illuminate\Database\Seeder;


class FoldersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Folder', 10)->create();
    }
}
