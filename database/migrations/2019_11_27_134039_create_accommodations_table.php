<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('rating')->unsigned()->nullable();
            $table->string('category', 200)->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->string('image', 100)->nullable();
            $table->integer('reputation')->unsigned()->nullable();
            $table->string('reputations_badge', 50)->nullable();
            $table->double('price', 15, 2)->nullable();
            $table->integer('availability')->unsigned()->nullable();

            $table->timestamps();

            $table->foreign('location_id')
            ->references('id')
            ->on('locations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodations');
    }
}
