<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->insert(
            [
                [
                    'alternative' => 'a',
                    'created_at'=> now(),
                    'description' => '𝑝/1,20',
                    'question_id' => '1',
                    'updated_at'=> now(),
                    'valid' => false,
                ],
                [
                    'alternative' => 'b',
                    'created_at'=> now(),
                    'description' => '𝑝/1,21',
                    'valid' => true,
                    'updated_at'=> now(),
                    'question_id' => '1',
                ],
                [
                    'alternative' => 'c',
                    'created_at'=> now(),
                    'description' => '𝑝 × 0,80.',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '1',
                ],
                [
                    'alternative' => 'd',
                    'created_at'=> now(),
                    'description' => '𝑝 × 0,81.',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '1',
                ],
                [
                    'alternative' => 'a',
                    'created_at'=> now(),
                    'description' => '10',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '2',
                ],
                [
                    'alternative' => 'b',
                    'created_at'=> now(),
                    'description' => '12',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '2',
                ],
                [
                    'alternative' => 'c',
                    'created_at'=> now(),
                    'description' => '14',
                    'valid' => true,
                    'updated_at'=> now(),
                    'question_id' => '2',
                ],
                [
                    'alternative' => 'd',
                    'created_at'=> now(),
                    'description' => '16',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '2',
                ],
                [
                    'alternative' => 'a',
                    'created_at'=> now(),
                    'description' => '17/20',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '3',
                ],

                [
                    'alternative' => 'b',
                    'created_at'=> now(),
                    'description' => '7/10',
                    'valid' => true,
                    'updated_at'=> now(),
                    'question_id' => '3',
                ],
                [
                    'alternative' => 'c',
                    'created_at'=> now(),
                    'description' => '3/10',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '3',
                ],
                [
                    'alternative' => 'd',
                    'created_at'=> now(),
                    'description' => '3/20',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '3',
                ],
                [
                    'alternative' => 'a',
                    'created_at'=> now(),
                    'description' => 'opcao a',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '4',
                ],
                [
                    'alternative' => 'b',
                    'created_at'=> now(),
                    'description' => 'opcao b',
                    'valid' => true,
                    'updated_at'=> now(),
                    'question_id' => '4',
                ],
                [
                    'alternative' => 'c',
                    'created_at'=> now(),
                    'description' => 'opcao c',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '4',
                ],
                [
                    'alternative' => 'd',
                    'created_at'=> now(),
                    'description' => 'opcao d',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '4',
                ],
                [
                    'alternative' => 'a',
                    'created_at'=> now(),
                    'description' => 'irracional',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '5',
                ],
                [
                    'alternative' => 'b',
                    'created_at'=> now(),
                    'description' => 'racional não inteiro',
                    'valid' => true,
                    'updated_at'=> now(),
                    'question_id' => '5',
                ],
                [
                    'alternative' => 'c',
                    'created_at'=> now(),
                    'description' => 'inteiro positivo',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '5',
                ],
                [
                    'alternative' => 'd',
                    'created_at'=> now(),
                    'description' => 'inteiro negativo',
                    'valid' => false,
                    'updated_at'=> now(),
                    'question_id' => '5',
                ],
            ]
    );
    }
}
