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
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->string('name');
<<<<<<< HEAD:database/migrations/2023_10_15_083613_create_blog_categories_table.php
            $table->tinyInteger('status')->nullable();
            $table->text('image');
=======
            $table->boolean('status')->nullable();
            $table->string('slug')->nullable();
>>>>>>> 94e4f2c (fixing sub category):database/migrations/2023_06_25_101532_create_product_categories_table.php
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
        Schema::dropIfExists('blog_categories');
    }
};
