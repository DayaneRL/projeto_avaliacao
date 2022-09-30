<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            [
                'name' => 'Fácil',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'name' => 'Médio',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'name' => 'Difícil',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
        ]);
    }
}
