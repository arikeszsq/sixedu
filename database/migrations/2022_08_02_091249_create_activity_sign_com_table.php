<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitySignComTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_sign_com', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->comment('活动ID');
            $table->integer('company_id')->comment('企业ID');
            $table->integer('creater_id')->default('NULL')->nullable()->comment('添加人');
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
        Schema::dropIfExists('activity_sign_com');
    }
}
