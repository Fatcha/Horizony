<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('countries', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('country_key',2);
            $table->string('country_key_alpha3',3)->nullable();

            $table->unique('country_key');
            $table->unique('country_key_alpha3');

            $table->timestamps();
        });
        Schema::create('countries_translation', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('country_key',2);
            $table->string('lang',2);
            $table->string('name',200);

            $table->timestamps();



            $table->index(['country_key', 'lang']);

            $table->foreign('country_key')->references('country_key')->on('countries');
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
        Schema::drop('countries_translation');
        Schema::drop('countries');
    }
}
