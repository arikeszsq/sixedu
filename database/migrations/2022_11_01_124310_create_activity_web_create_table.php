<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityWebCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_web_create', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop_name')->nullable()->comment('商家名');
            $table->string('contacter')->nullable()->comment('联系人');
            $table->string('mobile')->nullable()->comment('联系电话');
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
        Schema::dropIfExists('activity_web_create');
    }
}
