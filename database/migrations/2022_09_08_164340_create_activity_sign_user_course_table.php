<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitySignUserCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_sign_user_course', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->comment('活动ID');
            $table->integer('school_id')->comment('机构校区ID');
            $table->integer('course_id')->comment('课程');
            $table->integer('user_id')->comment('用户ID');
            $table->string('sign_user_id')->nullable()->comment('报名学生表ID');
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
        Schema::dropIfExists('activity_sign_user_course');
    }
}
