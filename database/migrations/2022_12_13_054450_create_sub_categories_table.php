<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->string('icon_photo')->nullable();
            $table->tinyInteger('sequence')->default(0);
            $table->tinyInteger('status')->default(\App\Models\SubCategory::ACTIVE)
                ->comment('1=Active,0=Inactive');

            $table->softDeletes();
            $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::table('sub_categories',function (Blueprint $table){
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('sub_categories');
    }
}
