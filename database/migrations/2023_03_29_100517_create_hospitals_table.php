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
            $table->string('status')->default(\App\Models\Hospital::ACTIVE);

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
        Schema::dropIfExists('hospitals');
    }
}
