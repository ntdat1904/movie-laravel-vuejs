<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('native_name')->nullable();
            $table->string('vietnamese_name')->nullable();
            $table->text('introduce')->nullable();
            $table->boolean('has_movie')->default(true);
            $table->float('IMDb_scores', 3, 1)->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('episode_number_current')->nullable();
            $table->integer('episode_number')->nullable();
            $table->integer('number_view')->nullable();
            $table->integer('number_like')->nullable();
            $table->integer('number_share')->nullable();
            $table->integer('realease_year')->nullable();
            $table->integer('time')->nullable();
            $table->integer('quality')->nullable();
            $table->integer('resolution')->nullable();
            $table->integer('type_language')->nullable();
            $table->integer('form')->nullable();
            $table->string('production_company')->nullable();
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
        Schema::dropIfExists('movies');
    }
}
