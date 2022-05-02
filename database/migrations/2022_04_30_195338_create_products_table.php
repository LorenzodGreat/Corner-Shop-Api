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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('name');
            $table->string('cost');
            $table->string('brand');
            $table->string('pic');
            $table->string('qty');
            $table->string('size');
            $table->string('color');
            $table->string('shipping');
            $table->string('ship_time');
            $table->string('ship_cost');
            $table->string('meta_title')->nullable();
            $table->string('meta_key')->nullable();
            $table->string('meta_details')->nullable();
            $table->string('details')->nullable();
            $table->tinyInteger('featured')->default('0')->nullable();
            $table->tinyInteger('popular')->default('0')->nullable();
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('products');
    }
};
