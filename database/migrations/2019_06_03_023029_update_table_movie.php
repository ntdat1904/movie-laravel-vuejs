<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableMovie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['quality','resolution','type_language','form','number_view','number_share', 'number_like']);
        });
        Schema::table('movies', function (Blueprint $table) {
            $table->enum('quality', ['Good', 'Normal'])->default('Normal');
            $table->enum('resolution', ['FHD', 'HD', 'CAM'])->default('CAM');
            $table->enum('type_language', ['Sub', 'EN'])->default('EN');
            $table->enum('form', ['Odd', 'Set'])->default('Odd');
            $table->integer('number_view')->default(0)->nullable(true);
            $table->integer('number_share')->default(0)->nullable(true);
            $table->integer('number_like')->default(0)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['quality','resolution','type_language','form']);
        });
        Schema::table('movies', function (Blueprint $table) {
            $table->integer('quality');
            $table->integer('resolution');
            $table->integer('type_language');
            $table->integer('form');
        });
    }
}
