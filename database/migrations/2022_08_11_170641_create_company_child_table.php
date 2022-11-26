<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyChildTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_child', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->default('NULL')->nullable();
            $table->string('name')->default('NULL')->nullable();
            $table->string('address')->default('NULL')->nullable();
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
        Schema::dropIfExists('company_child');
    }
}
