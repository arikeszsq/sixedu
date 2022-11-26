<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('leader_id')->nullable()->comment('团长');
            $table->integer('creater_id')->nullable()->comment('开团人');
            $table->dateTime('success_time')->nullable()->comment('成团时间');
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
        Schema::dropIfExists('activity_group');
    }
}
