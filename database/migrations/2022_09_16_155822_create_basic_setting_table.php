<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasicSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kf_name')->nullable()->comment('客服名字');
            $table->string('mobile')->nullable()->comment('手机号');
            $table->string('pic')->nullable()->comment('客服二维码');
            $table->text('buy_protocal')->nullable()->comment('购买协议');
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
        Schema::dropIfExists('basic_setting');
    }
}
