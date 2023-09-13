<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiggaponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biggapons', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('target_url')->default('#');
            $table->string('place')->default(\App\Models\Biggapon::TOP);
            $table->string('show_on_page')->default(\App\Models\Biggapon::HOME_PAGE);
            $table->string('status')->default(\App\Models\Biggapon::ACTIVE);
            $table->dateTime('active_till')->nullable()->default(now()->addMonth(1));

            $table->tinyInteger('sequence',false,4)->default(1);
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
        Schema::dropIfExists('biggapons');
    }
}
