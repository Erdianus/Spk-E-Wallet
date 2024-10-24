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
        Schema::create('perbandingan_kriterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_baris_id')->references('id')->on('criterias')->onDelete('cascade');
            $table->foreignId('criteria_kolom_id')->references('id')->on('criterias')->onDelete('cascade');
            $table->foreignId('responden_id')->references('id')->on('respondents')->onDelete('cascade');
            $table->integer('nilai');
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
        Schema::dropIfExists('perbandingan_kriterias');
    }
};
