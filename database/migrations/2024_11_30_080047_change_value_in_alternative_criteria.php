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
        Schema::table('alternative_criteria', function (Blueprint $table) {
            $table->decimal('value', total: 11, places: 2)->change();
        });
        Schema::table('criterias', function (Blueprint $table) {
            $table->boolean('decimal_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alternative_criteria', function (Blueprint $table) {
            $table->integer('value')->nullable()->change();
        });
        Schema::table('criterias', function (Blueprint $table) {
            $table->dropColumn('decimal_value');
        });
    }
};
