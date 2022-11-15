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
        Schema::create('dishes', function (Blueprint $table) {
            $table->uuid('dish_id')->primary();
            $table->string('dish_name');
            $table->string('dish_description');
            $table->float('dish_price');
            $table->float('dish_rating');
            $table->uuid('restaurant_id')->foreignId('restaurant_id')->constrained('restaurants');
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
        Schema::dropIfExists('dishes');
    }
};
