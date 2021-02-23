<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('链接名称');
            $table->string('url')->default('')->comment('链接网址');
            $table->string('lianxi')->nullable()->comment('联系方式');
            $table->integer('state')->default('1')->comment('状态');
            $table->tinyInteger('linktype')->default('0')->comment('链接类型');
            $table->string('beizhu')->nullable()->comment('备注');
            $table->string('logo')->nullable();
            $table->timestamp('expired_at')->nullable()->comment('过期时间');
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
        Schema::dropIfExists('links');
    }
}
