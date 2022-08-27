<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateAdmin extends Command
{

    protected $signature = 'create:admin {name} {email} {password}';

    protected $description = 'Cria um novo usuário administrador';

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
            'admin'=>true
        ]);

        $this->info('Usuário criado com sucesso');
    }
}
