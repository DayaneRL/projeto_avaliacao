<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateUser extends Command
{

    protected $signature = 'create:user {name} {email} {password}';

    protected $description = 'Cria um novo usuário';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        User::create([
            'name'=>$name,
            'email'=>$email,
            'password'=>$password,
        ]);

        $this->info('Usuário criado com sucesso');
    }
}
