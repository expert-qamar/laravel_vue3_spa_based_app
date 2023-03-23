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
        Schema::create('car_details', function (Blueprint $table) {
            $table->id();
            $table->string('model', )->nullable(true);
            $table->string('register_no', )->nullable(true);
            $table->foreignId('category_id', )->constrained('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('color', )->nullable(true);
            $table->string('making_year', )->nullable(true);
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
        Schema::dropIfExists('car_details');
    }
};
