<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserApplyCashOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_apply_cash_out', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->comment('申请人');
            $table->decimal('apply_money')->nullable()->comment('本地申请提现的金额');
            $table->decimal('history_total_money')->nullable()->comment('历史提现总金额');
            $table->decimal('current_stay_money')->nullable()->comment('当前剩余可提现的金额');
            $table->string('pay_order')->nullable()->comment('打款订单号');
            $table->dateTime('pay_time')->nullable()->comment('打款时间');
            $table->tinyInteger('pay_status')->nullable()->comment('打款状态');
            $table->tinyInteger('status')->nullable()->comment('审核状态 1待 2 同 3拒绝');
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
        Schema::dropIfExists('user_apply_cash_out');
    }
}
