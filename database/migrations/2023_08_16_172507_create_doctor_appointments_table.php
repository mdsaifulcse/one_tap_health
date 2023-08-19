<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {
        Schema::create('doctor_appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_no',20);
            $table->unsignedBigInteger('user_id')->nullable()->comment('User table id')->nullable();
            $table->unsignedBigInteger('refer_by_id')->nullable()->comment('User table id')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->double('amount',8,1)->default(0);
            $table->double('discount',7,1)->default(0);
            $table->double('service_charge',7,1)->default(0);
            $table->double('total_amount',8,1)->default(0)->comment('(amount-discount)+service charge');
            $table->double('reconciliation_amount',8,1)->default(0)->comment('This is the final payable amount');
            $table->double('system_commission',8,1)->default(0)->comment(' That amount system (company earn)');
            $table->timestamp('appointment_date')->comment('Doctor Appointment date');
            $table->tinyInteger('appointment_status',false,1)->default(\App\Models\DoctorAppointment::NO);
            $table->tinyInteger('approval_status',false,2)->default(\App\Models\DoctorAppointment::PENDING);
            $table->tinyInteger('payment_status',false,1)->default(\App\Models\DoctorAppointment::PENDING);
            $table->string('source')->default(\App\Models\DoctorAppointment::SOURCEMOBILE);
            $table->text('note')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('refer_by_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
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
        Schema::table('doctor_appointments',function (Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['refer_by_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('doctor_appointments');
    }
}
