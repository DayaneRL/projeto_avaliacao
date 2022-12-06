<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Answer,User,ExamQuestion};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers_private', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('alternative', 2); // a, b, c or d
            $table->tinyInteger('valid')->nullable(); //0 or 1
            $table->foreignIdFor(Answer::class)->nullable();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(ExamQuestion::class);

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
        Schema::dropIfExists('answers_private');
    }
};
