<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->string('email',150)->nullable();
            $table->string('mobile',150)->nullable();
            $table->string('contact',150)->nullable();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->text('address')->nullable();
            $table->text('current_chamber')->nullable();
            $table->string('institute')->nullable();
            $table->string('designation')->nullable();
            $table->string('degree')->nullable();
            $table->string('department')->nullable();
            $table->string('specialist')->nullable();
            $table->integer('bmdc_no',false,6)->nullable();
            $table->integer('sequence',false,4)->default(0);
            $table->string('status')->default(\App\Models\Doctor::ACTIVE);

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
        Schema::table('doctors',function (Blueprint $table){
            $table->dropForeign(['test_id']);
            $table->dropForeign(['hospital_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('doctors');
    }
}
