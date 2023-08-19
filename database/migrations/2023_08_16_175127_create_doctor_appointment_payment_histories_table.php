<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorAppointmentPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_appointment_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('doctor_appointment_id');
            $table->timestamp('payment_date');
            $table->double('payment_amount',8,1)->default(0);
            $table->double('store_amount',8,1)->default(0);
            $table->string('payment_type',100)->default(\App\Models\TestOrderPaymentHistory::CASHONDELIVERY)->comment('cash or online payment');
            $table->text('payment_track')->nullable();
            $table->string('payment_gateway',100)->nullable();
            $table->string('transaction_id',100)->nullable();
            $table->string('currency',5)->nullable();
            $table->tinyInteger('payment_status',false,1)->default(\App\Models\TestOrderPaymentHistory::INITIATE);

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('doctor_appointment_id')->references('id')->on('doctor_appointments')->cascadeOnDelete();
            $table->unsignedBigInteger('created_by', false)->nullable();
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
        Schema::table('doctor_appointment_payment_histories',function (Blueprint $table){
        //$table->dropForeign(['doctor_appointment_id']);
        $table->dropForeign(['user_id']);
        $table->dropForeign(['created_by']);
        $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('doctor_appointment_payment_histories');
    }
}
