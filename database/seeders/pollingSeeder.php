<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class pollingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pollings')->insert([
            'pollingname' => Str::random(),
        ]);
        $this->call([
            SelectionSeeder::class
        ]);
    }
}
