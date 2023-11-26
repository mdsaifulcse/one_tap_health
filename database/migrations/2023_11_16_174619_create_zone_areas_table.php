<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoneAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id');
            $table->string('name',30);
            $table->string('bn_name',50)->nullable();
            $table->text('details')->nullable();
            $table->string('lat',20)->nullable();
            $table->string('long',20)->nullable();
            $table->tinyInteger('status')->default(\App\Models\ZoneArea::ACTIVE);

            $table->foreign('district_id')->references('id')->on('districts')->cascadeOnDelete();
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
        Schema::table('zone_areas',function (Blueprint $table) {
            $table->dropForeign(['district_id']);
        });

        Schema::dropIfExists('zone_areas');
    }
}
