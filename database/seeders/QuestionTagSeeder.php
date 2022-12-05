<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_tags')->insert([
            [
                'question_id' => '1',
                'tag_id' => '7',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'question_id' => '2',
                'tag_id' => '5',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'question_id' => '3',
                'tag_id' => '6',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'question_id' => '4',
                'tag_id' => '4',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'question_id' => '5',
                'tag_id' => '7',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'question_id' => '6',
                'tag_id' => '2',
                'created_at'=> now(),
                'updated_at'=> now()
            ],

            [
                'question_id' => '7',
                'tag_id' => '3',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'question_id' => '8',
                'tag_id' => '3',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'question_id' => '9',
                'tag_id' => '3',
                'created_at'=> now(),
                'updated_at'=> now()
            ],
        ]);
    }
}
