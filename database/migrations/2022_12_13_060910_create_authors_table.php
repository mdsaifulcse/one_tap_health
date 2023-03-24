<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->string('email',100)->nullable();
            $table->string('mobile',15)->nullable();
            $table->string('photo')->nullable();
            $table->string('contact',50)->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->text('bio')->nullable();

            $table->tinyInteger('show_home')->default(\App\Models\Author::NO)
                ->comment('1=Yes,0=NO');
            $table->tinyInteger('status')->default(\App\Models\Author::ACTIVE)
                ->comment('1=Active,0=Inactive');
            $table->integer('sequence',false,4)->default(0);

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
        Schema::table('authors',function (Blueprint $table){
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('authors');
    }
}
