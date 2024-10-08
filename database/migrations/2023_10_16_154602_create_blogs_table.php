<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
<<<<<<< HEAD:database/migrations/2023_10_16_154602_create_blogs_table.php
            $table->string('title');
            $table->tinyInteger('status')->nullable();
            $table->string('image');
            $table->longText('desc');
=======
            $table->string('name');
            $table->boolean('status')->nullable();
            $table->string('slug')->nullable();
>>>>>>> 94e4f2c (fixing sub category):database/migrations/2023_08_10_152423_create_child_categories_table.php
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('updated_by_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};
