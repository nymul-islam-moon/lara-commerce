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
        Schema::create('product_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->string('code')->nullable();
            $table->string('name');
            $table->tinyInteger('status')->nullable();
            $table->string('slug')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('CASCADE');
            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('updated_by_id')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sub_categories');
    }
};
