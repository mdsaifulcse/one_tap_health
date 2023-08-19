<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorAppointmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_appointment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_appointment_id');
            $table->unsignedBigInteger('hospital_id');
            $table->unsignedBigInteger('doctor_id');
            $table->string('time_slot',50);
            $table->string('appointment_day',10)->nullable()->comment('Sun,Mon,Fri');
            $table->integer('doctor_fee',false,6)->default(0);
            $table->integer('discount',false,6)->default(0);
            $table->string('chamber_no',10)->nullable();
            $table->string('serial_no',10)->nullable();
            $table->text('doctor_schedule_details')->nullable();

            $table->foreign('doctor_appointment_id')->references('id')->on('doctor_appointments')->cascadeOnDelete();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->cascadeOnDelete();
            $table->foreign('doctor_id')->references('id')->on('doctors')->cascadeOnDelete();
            $table->unsignedBigInteger('created_by', false);
            $table->unsignedBigInteger('updated_by', false)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::table('doctor_appointment_details',function (Blueprint $table){
            $table->dropForeign(['doctor_appointment_id']);
            $table->dropForeign(['hospital_id']);
            $table->dropForeign(['doctor_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('doctor_appointment_details');
    }
}
