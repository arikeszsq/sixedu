<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAwardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_award', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->default('NULL')->nullable();
            $table->integer('user_id')->default('NULL')->nullable();
            $table->integer('award_id')->default('NULL')->nullable();
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
        Schema::dropIfExists('user_award');
    }
}
