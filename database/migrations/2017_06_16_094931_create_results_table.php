<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id')->unsigned();
            $table->integer('word_id')->unsigned();
            $table->string('user_answer', 150)->nullable();
            $table->timestamps();

            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons')
                ->onDelete('cascade');
            $table->foreign('word_id')
                ->references('id')
                ->on('words')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
