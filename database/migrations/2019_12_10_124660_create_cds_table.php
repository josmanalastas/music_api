<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cds', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('owner_id')->unsigned();
            $table->integer('composer_id')->unsigned();
            $table->integer('artist_id')->unsigned();
            $table->integer('genre_id')->unsigned();
            $table->string('album_title', 200);
            $table->string('album_catalog_no', 100);
            $table->integer('release_year')->nullable(false);
            $table->foreign('owner_id')->references('id')->on('owners');
            $table->foreign('artist_id')->references('id')->on('artists');
            $table->foreign('genre_id')->references('id')->on('genres');
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
        Schema::dropIfExists('cds');
    }
}
