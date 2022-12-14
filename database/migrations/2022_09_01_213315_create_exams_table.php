<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Category,User,UserHeader};

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('tags')->nullable();
            $table->string('number_of_questions');
            $table->date('date')->nullable();
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(UserHeader::class)->nullable(); //null = default image
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
        Schema::dropIfExists('exams');
    }
}
