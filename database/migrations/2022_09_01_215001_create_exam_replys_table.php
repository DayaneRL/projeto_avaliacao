<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Question;

class CreateExamReplysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_replys', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Question::class);
            $table->string('text');
            $table->string('alternative', 10); // a, b, c or d
            $table->tinyInteger('valid')->nullable(); //0 or 1
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_replys');
    }
}
