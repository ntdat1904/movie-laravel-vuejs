<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldCountryIdTblMovies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['country_id']);
        });
        Schema::table('movies', function (Blueprint $table) {
            $table->string('country_id',255)->nullable()->after('IMDb_scores');
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
            $table->dropColumn(['country_id']);
        });
        Schema::table('movies', function (Blueprint $table) {
            $table->integer('country_id',11)->nullable()->after('IMDb_scores');
        });
    }
}
