<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('patient_no',20)->comment('patient id number');
            $table->string('name',150);
            $table->string('age',50)->nullable();
            $table->string('mobile',20)->nullable();
            $table->string('email',20)->nullable();
            $table->string('address',20)->nullable();
            $table->text('details')->nullable();
            $table->integer('sequence',false,4)->default(0);
            $table->string('status')->default(\App\Models\Patient::ACTIVE);

            $table->unsignedBigInteger('refer_by_id')->comment('User table id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('refer_by_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::table('patients',function (Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['refer_by_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('patients');
    }
}
