<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('zone_area_id')->nullable();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('branch')->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('photo')->nullable();
            $table->string('contact')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->text('service_details')->nullable();

            $table->string('show_home')->default(\App\Models\Hospital::NO);
            $table->integer('sequence',false,4)->default(0);
            $table->tinyInteger('status')->default(\App\Models\Hospital::ACTIVE);

            $table->foreign('district_id')->references('id')->on('districts')->cascadeOnDelete();
            $table->foreign('zone_area_id')->references('id')->on('zone_areas')->cascadeOnDelete();
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
        Schema::table('hospitals',function (Blueprint $table){
            $table->dropForeign(['district_id']);
            $table->dropForeign(['zone_area_id']);
        });

        Schema::dropIfExists('hospitals');
    }
}
