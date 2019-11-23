<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tek_support_id')->unsigned();
            $table->string("nama_project");
            $table->string("status");
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('project');
    }
}
