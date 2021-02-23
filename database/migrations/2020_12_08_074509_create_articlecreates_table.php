<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlecreatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articlecreates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('typeid');
            $table->string('title')->default('');
            $table->string('shorttitle')->nullable();
            $table->string('tags')->nullable();
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->integer('ismake')->default('1');
            $table->integer('click');
            $table->string('flags')->nullable();
            $table->string('write')->default('');
            $table->string('litpic')->nullable();
            $table->text('body')->nullable();
            $table->string('published_at')->nullable();
            $table->mediumText('imagepics')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articlecreates');
    }
}
