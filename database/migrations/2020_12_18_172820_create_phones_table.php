<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone')->default('')->comment('电话号码');
            $table->string('name')->nullable()->comment('客户姓名');
            $table->string('remark')->nullable()->comment('备注');
            $table->ipAddress('IP')->nullable()->comment('IP');
            $table->string('host')->nullable()->comment('来源页面');
            $table->string('referer')->nullable()->comment('数据来源');
            $table->string('state')->default('1')->nullable()->comment('状态');
			$table->string('saler')->nullable()->comment('跟进人');
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
        Schema::dropIfExists('phones');
    }
}
