<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('annotation_id')->constrained('annotations')->onDelete('cascade');
            $table->foreignId('book_screen_shot_id')->nullable()->constrained('book_screen_shots')->onDelete('cascade');
            $table->longText('annotated_question')->nullable()->comment('for image search');
            $table->longText('question')->nullable()->comment('main question');
            $table->text('screen_shot_location')->nullable();
            $table->unsignedBigInteger('priority')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
