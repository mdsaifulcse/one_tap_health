<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestOrderCancelRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_order_cancel_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_order_id');
            $table->string('notes')->nullable();
            $table->tinyInteger('cancel_status',false,1)->default(\App\Models\TestOrderCancelRequest::PENDING);
            $table->tinyInteger('refund_status',false,1)->default(\App\Models\TestOrderCancelRequest::NOTREFUNDED);
            $table->integer('refund_amount',false,6)->default(0);

            $table->unsignedBigInteger('cancel_by', false)->nullable();
            $table->foreign('cancel_by')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamp('cancel_at')->nullable();

            $table->unsignedBigInteger('refund_by', false)->nullable();
            $table->foreign('refund_by')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamp('refund_at')->nullable();

            $table->unsignedBigInteger('created_by', false);
            $table->unsignedBigInteger('updated_by', false)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('test_order_id')->references('id')->on('test_orders')->cascadeOnDelete();
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
        Schema::table('test_order_cancel_requests',function (Blueprint $table){
            $table->dropForeign(['test_order_id']);
            $table->dropForeign(['cancel_by']);
            $table->dropForeign(['refund_by']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('test_order_cancel_requests');
    }
}
