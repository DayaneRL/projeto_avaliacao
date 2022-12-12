<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre

Projeto de Avaliações escolares.
Projeto Integrado II de Analise e Desenvolvimento de sistemas.

### Funcionalidades

É possível cadastrar usuários e administradores.
Administradores gerenciam usuários e, usuários gerenciam cabeçalhos de provas e avaliações.

Foco em cadastrar provas consumindo um banco de questões e/ou cadastradndo perguntas privadas.

As avaliações e o gabarito de respostas podem ser baixadas em PDF.

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<br/>
<br/>

### Comandos
1. composer install <br/>
2. npm install <br/>
3. cp .env.example .env <br/>
4. php artisan storage:link <br/>
5. php artisan key:generate <br/>
6. php artisan serve

<br/> <br/>

### Bug
Ao instalar o projeto, caso apresente o erro 'The PHP GD extension is required, but is not installed' ao tentar baixar o PDF, ele pode ser corrigido descomentando a linha ';extension=php_gd2.dll' do arquivo *php.ini* , conforme apresentado nesse link: 
<a href="https://stackoverflow.com/questions/39384644/extension-gd-is-missing-from-your-system-laravel-composer-update">Correção</a>
