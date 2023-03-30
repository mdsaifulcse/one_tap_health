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

            $table->string('third_sub_category',150)->nullable();
            $table->string('third_sub_category_bn',150)->nullable();
            $table->string('link')->nullable();

            $table->text('description')->nullable();

            $table->string('icon_photo')->nullable();
            $table->string('icon_class')->nullable();
            $table->tinyInteger('sequence')->default(0);
            $table->string('status')->default(\App\Models\ThirdSubCategory::ACTIVE);
            $table->unsignedBigInteger('created_by', false);
            $table->unsignedBigInteger('updated_by', false)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
            $table->softDeletes();

            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->cascadeOnDelete();
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
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('third_sub_categories');
    }
}
