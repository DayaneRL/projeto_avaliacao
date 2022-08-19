<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateUserHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_headers', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->text('description');
            $table->foreignIdFor(User::class);
            //Idéia: inputs NomeEscola, NomeAvaliacao, Turma, Professor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_headers');
    }
}
