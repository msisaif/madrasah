<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedTinyInteger('class_id');
            $table->string('session')->nullable();
            $table->unsignedTinyInteger('status')->default(1)->comment('1=Admission Form, 2=Fee Form, 3=Admission Complete');
            $table->unsignedSmallInteger('roll')->nullable();
            $table->string('previous_school')->nullable();
            $table->string('previous_class')->nullable();
            $table->string('previous_roll')->nullable();
            $table->string('previous_result')->nullable();
            $table->unsignedFloat('admission_test_mark')->nullable();
            $table->json('verifications')->nullable();
            $table->unsignedInteger('verified_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admissions');
    }
}
