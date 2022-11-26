<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitySignUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_sign_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->comment('活动ID');
            $table->integer('group_id')->nullable()->comment('团ID');
            $table->tinyInteger('role')->nullable()->comment('1团长  2团员');
            $table->integer('user_id')->comment('用户ID');
            $table->tinyInteger('type')->default('2')->nullable()->comment('1开团 2单独购买');
            $table->integer('creater_id')->nullable()->comment('添加人');
            $table->string('share_q_code')->nullable()->comment('分享二维码');
            $table->string('order_no')->nullable()->comment('订单号');
            $table->decimal('money')->nullable()->comment('支付金额');
            $table->tinyInteger('has_pay')->default('2')->nullable()->comment('1是 2 否');
            $table->tinyInteger('status')->default('1')->comment('1 待支付 2支付取消 3支付成功');
            $table->dateTime('pay_time')->nullable()->comment('支付时间');
            $table->dateTime('pay_cancel_time')->nullable()->comment('支付取消时间');
            $table->string('sign_name')->nullable()->comment('报名学生姓名');
            $table->string('sign_mobile')->nullable()->comment('报名手机号');
            $table->string('sign_age')->nullable()->comment('报名学生年龄');
            $table->tinyInteger('sign_sex')->default('1')->nullable()->comment('1男2女');
            $table->tinyInteger('is_agree')->default('1')->nullable();
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
        Schema::dropIfExists('activity_sign_user');
    }
}
