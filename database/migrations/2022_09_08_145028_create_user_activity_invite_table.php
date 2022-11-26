<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActivityInviteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activity_invite', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->comment('活动');
            $table->integer('A_user_id')->default('0')->nullable()->comment('A 一级邀请人');
            $table->integer('parent_user_id')->comment('直接邀请人');
            $table->integer('invited_user_id')->comment('被邀请人');
            $table->integer('has_pay')->default('2')->nullable()->comment('1 已支付 2 未支付');
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
        Schema::dropIfExists('user_activity_invite');
    }
}
