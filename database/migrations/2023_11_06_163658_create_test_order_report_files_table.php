<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestOrderReportFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_order_report_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_order_id');
            $table->text('files')->nullable();
            $table->string('title',120)->nullable();
            $table->text('notes')->nullable();
            $table->tinyInteger('status')->default(\App\Models\TestOrderReportFile::ACTIVE)
                ->comment('1=Active,0=Inactive');

            $table->foreign('test_order_id')->references('id')->on('test_orders')->cascadeOnDelete();
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
        Schema::table('test_order_report_files',function (Blueprint $table){
            $table->dropForeign(['test_order_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('test_order_report_files');
    }
}
