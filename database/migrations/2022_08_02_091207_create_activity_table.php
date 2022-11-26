<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('''')->comment('标题');
            $table->tinyInteger('is_many')->default('1')->comment('是否多商家，1是2否');
            $table->string('description')->default('NULL')->nullable()->comment('描述');
            $table->string('content')->default('NULL')->nullable()->comment('内容');
            $table->decimal('ori_price')->default('NULL')->nullable()->comment('原价');
            $table->decimal('real_price')->default('NULL')->nullable()->comment('真实价格');
            $table->integer('status')->default('NULL')->nullable()->comment('状态 1：上架  2：下架');
            $table->dateTime('start_time')->default('NULL')->nullable()->comment('活动开始时间');
            $table->dateTime('end_time')->default('NULL')->nullable()->comment('活动结束时间');
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
        Schema::dropIfExists('activity');
    }
}
