<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('sub_title', 255);
            $table->string('author', 255);
            $table->enum('reading_status', ['read', 'to-read', 'pending']);
            $table->string('resume');
            $table->string('format');
            $table->integer('number_of_pages');
            $table->date('release_date');
            $table->string('editor');
            $table->string('isbn');
            $table->binary('cover_image')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('cover_image_name')->nullable();
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table
            ->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('restrict')
            ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
