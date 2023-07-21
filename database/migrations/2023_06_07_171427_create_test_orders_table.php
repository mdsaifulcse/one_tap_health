<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no',20);
            $table->unsignedBigInteger('refer_by_id')->comment('User table id')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('hospital_id');
            $table->double('amount',8,1)->default(0);
            $table->double('discount',7,1)->default(0);
            $table->double('service_charge',7,1)->default(0);
            $table->double('total_amount',7,1)->default(0)->comment('(amount-discount)+service charge');
            $table->double('reconciliation_amount',7,1)->default(0)->comment('This is the final payable amount');
            $table->timestamp('test_date')->comment('when a Patient wants to be tested');
            $table->tinyInteger('approval_status',false,2)->default(\App\Models\TestOrder::PENDING);
            $table->tinyInteger('visit_status',false,1)->default(\App\Models\TestOrder::NO);
            $table->tinyInteger('payment_status',false,1)->default(\App\Models\TestOrder::PENDING);
            $table->tinyInteger('delivery_status',false,2)->default(\App\Models\TestOrder::PROCESSION);
            $table->timestamp('delivery_date')->nullable();
            $table->string('source')->default(\App\Models\TestOrder::SOURCEMOBILE);
            $table->text('note')->nullable();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
            $table->foreign('refer_by_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->cascadeOnDelete();
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
        Schema::table('test_orders',function (Blueprint $table){
            $table->dropForeign(['refer_by_id']);
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['hospital_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('test_orders');
    }
}
