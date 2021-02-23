<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArctypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arctypes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->index()->default('0');
            $table->integer('order')->index()->default('0')->comment('栏目排序');
            $table->string('title')->index()->default('')->comment('栏目名称');
            $table->string('typedir')->default('');
            $table->string('seotitle')->default('');
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->integer('is_write');
			$table->smallInteger('dirposition')->default(1);
            $table->string('real_path')->index()->nullable();
            $table->string('litpic')->nullable();
            $table->text('typeimages')->nullable();
            $table->text('contents')->nullable();
            $table->integer('mid')->default('0');
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
        Schema::dropIfExists('arctypes');
    }
}
