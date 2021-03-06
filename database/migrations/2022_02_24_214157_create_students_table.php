<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('registration')->nullable();

            $table->unsignedTinyInteger('status')->default(1)->comment('0=Inactive, 1=Active, 2=Admission is ongoing');

            $table->unsignedTinyInteger('resident');

            $table->unsignedTinyInteger('gender')->nullable()->comment('1=Male, 2=Female');
            $table->unsignedTinyInteger('blood_group')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('birth_certificate')->nullable();

            $table->unsignedBigInteger('father_info_id')->nullable();
            $table->unsignedBigInteger('mother_info_id')->nullable();
            $table->unsignedBigInteger('guardian_info_id')->nullable();

            $table->unsignedBigInteger('present_address_id')->nullable();
            $table->unsignedBigInteger('permanent_address_id')->nullable();

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
        Schema::dropIfExists('students');
    }
}
