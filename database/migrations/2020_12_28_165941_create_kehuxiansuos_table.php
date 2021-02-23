<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKehuxiansuosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kehuxiansuos', function (Blueprint $table) {
            $table->id();
			$table->integer('phone_id')->index()->comment('客户线索id');
			$table->string('tracer_id')->comment('客户线索跟踪者id');
            $table->string('remark')->comment('客户线索备注');
            $table->integer('remark_type')->comment('客户线索备注类型');
            $table->integer('valid')->index()->default('1')->comment('客户线索是否有效');
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
        Schema::dropIfExists('kehuxiansuos');
    }
}
