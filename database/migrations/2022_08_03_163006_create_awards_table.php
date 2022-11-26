<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('NULL')->nullable();
            $table->string('short_name')->default('NULL')->nullable();
            $table->string('logo')->default('NULL')->nullable();
            $table->string('description')->default('NULL')->nullable();
            $table->integer('invite_num')->default('0')->nullable()->comment('邀请人数 0 表示免费');
            $table->tinyInteger('status')->default('NULL')->nullable()->comment('1:有效 2：无效');
            $table->decimal('price')->default('NULL')->nullable()->comment('价值');
            $table->tinyInteger('is_commander')->default('2')->nullable()->comment('团长才可以领取 1是 2否');
            $table->tinyInteger('group_ok')->default('2')->nullable()->comment('拼团成功才可以领取 1是 2否');
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
        Schema::dropIfExists('awards');
    }
}
