<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Question, User, ExamQuestion};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_private', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('image');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Question::class);
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
        Schema::dropIfExists('questions_private');
    }
};
