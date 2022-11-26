<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_course', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->default('NULL')->nullable();
            $table->integer('company_Id')->default('NULL')->nullable();
            $table->string('logo')->default('NULL')->nullable();
            $table->string('name')->default('NULL')->nullable();
            $table->decimal('price')->default('NULL')->nullable()->comment('价值');
            $table->integer('total_num')->default('NULL')->nullable()->comment('总份数');
            $table->integer('sale_num')->default('NULL')->nullable()->comment('已售份数');
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
        Schema::dropIfExists('company_course');
    }
}
