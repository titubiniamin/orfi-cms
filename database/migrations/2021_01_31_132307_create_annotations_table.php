<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('book_screen_shot_id')->nullable()->constrained('book_screen_shots')->onDelete('cascade');
            $table->text('x_coordinate')->nullable();
            $table->text('y_coordinate')->nullable();
            $table->text('height')->nullable();
            $table->text('width')->nullable();
            $table->text('cropped_image')->nullable();
            $table->bigInteger('page_number')->unsigned()->nullable();
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
        Schema::dropIfExists('annotations');
    }
}
