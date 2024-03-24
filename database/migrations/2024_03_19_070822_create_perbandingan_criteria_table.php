<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perbandingan_criteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->references('id')->on('criterias')->onDelete('cascade');
            $table->foreignId('alternative_id')->references('id')->on('alternatives')->onDelete('cascade');
            $table->integer('weight')->nullable();
            $table->integer('for_criteria')->nullable();
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
        Schema::dropIfExists('perbandingan_criteria');
    }
};
