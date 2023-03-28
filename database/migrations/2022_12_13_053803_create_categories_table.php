<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('category_name',100)->nullable();
            $table->string('category_name_bn',150)->nullable();
            $table->string('link',255)->nullable();
            $table->text('short_description')->nullable();
            $table->string('icon_photo')->nullable();
            $table->string('icon_class')->nullable();
            //$table->tinyInteger('type')->default(1)->comment('1=Business, 2=Product');
            $table->tinyInteger('sequence')->default(0);
            $table->tinyInteger('status')->default(\App\Models\Category::ACTIVE)
                ->comment('1=Active,0=Inactive');
            $table->tinyInteger('show_home')->default(\App\Models\Category::NO)
                ->comment('1=Yes,0=No');

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
        Schema::dropIfExists('categories');
    }
}
