<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'name'      => 'admin',
                    'email'     => 'admin@admin.com',
                    'password'  => Hash::make('password'),
                    'admin'     => true,
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'      => 'Wladimir User Silva',
                    'email'     => 'user@user.com',
                    'password'  => Hash::make('password'),
                    'admin'     => false,
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'      => 'dev',
                    'email'     => 'dev@dev.com',
                    'password'  => Hash::make('password'),
                    'admin'     => false,
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
            ]
    );
    }
}
