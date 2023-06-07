<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_order_id');
            $table->unsignedBigInteger('hospital_id');
            $table->unsignedBigInteger('test_id');
            $table->double('price',7,1);
            $table->tinyInteger('approval_status',false,2)->default(\App\Models\TestOrder::PENDING);
            $table->tinyInteger('delivery_status',false,2)->default(\App\Models\TestOrder::PROCESSION);
            $table->timestamp('delivery_date')->nullable();

            $table->foreign('test_order_id')->references('id')->on('test_orders')->cascadeOnDelete();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->cascadeOnDelete();
            $table->foreign('test_id')->references('id')->on('tests')->cascadeOnDelete();
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
        Schema::table('test_order_details',function (Blueprint $table){
            $table->dropForeign(['test_order_id']);
            $table->dropForeign(['hospital_id']);
            $table->dropForeign(['test_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('test_order_details');
    }
}
