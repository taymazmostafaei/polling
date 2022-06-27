<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('votes')->insert([
            'selection_id' => 3
        ]);
        DB::table('votes')->insert([
            'selection_id' => 3
        ]);
        DB::table('votes')->insert([
            'selection_id' => 3
        ]);
        DB::table('votes')->insert([
            'selection_id' => 1
        ]);
        DB::table('votes')->insert([
            'selection_id' => 3
        ]);
    }
}
