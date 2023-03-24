<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_sub_categories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sub_category_id');
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->string('icon_photo')->nullable();
            $table->tinyInteger('sequence')->default(0);
            $table->tinyInteger('status')->default(\App\Models\ThirdSubCategory::ACTIVE)
                ->comment('1=Active,0=Inactive');

            $table->softDeletes();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
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
        Schema::table('third_sub_categories',function (Blueprint $table){
            $table->dropForeign(['sub_category_id']);
        });

        Schema::dropIfExists('third_sub_categories');
    }
}
