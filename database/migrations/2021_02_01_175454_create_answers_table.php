<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annotation_id')->constrained('annotations')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->foreignId('book_screen_shot_id')->nullable()->constrained('book_screen_shots')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->string('index_id')->unique()->nullable()->comment('elasticsearch index id');
            $table->text('index_name')->nullable()->comment('elasticsearch index name');
            $table->longText('annotated_answer')->nullable()->comment('for image search');
            $table->longText('answer')->nullable()->comment('main answer');
            $table->text('screen_shot_location')->nullable();
            $table->enum('type', ['answer', 'diagram'])->nullable();
            $table->bigInteger('likes')->unsigned()->default(0);
            $table->integer('review')->unsigned()->default(0);
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
        Schema::dropIfExists('answers');
    }
}
