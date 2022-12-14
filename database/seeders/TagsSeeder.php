<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
                'description' => 'Primeira Guerra',
                'category_id'=>'4',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'description' => 'Guerra Fria',
                'category_id'=>'4',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'description' => 'Bhaskara',
                'category_id'=>'2',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'description' => 'Álgebra',
                'category_id'=>'2',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'description' => 'Estatística',
                'category_id'=>'2',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'description' => 'Pitagoras',
                'category_id'=>'2',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'description' => 'Porcentagem',
                'category_id'=>'2',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
        ]);
    }
}
