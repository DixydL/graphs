<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGraphs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graphs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('weight');
            $table->timestamps();
        });

        Schema::create('graph_bind', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('child_id');
            $table->primary(['parent_id', 'child_id']);
            $table->foreign('parent_id')->references('id')->on('graphs');
            $table->foreign('child_id')->references('id')->on('graphs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('graph_bind');
        Schema::dropIfExists('graphs');
    }
}
