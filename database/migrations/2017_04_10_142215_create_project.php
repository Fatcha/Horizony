<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProject extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->string('name',150)->nullable();
                $table->string('job_number')->nullable()->unique();
                $table->string('status',50)->nullable();
                $table->integer('company_id')->unsigned()->nullable();
                $table->dateTime('end_expectation')->nullable();

                $table->unsignedInteger('user_pm_id')->nullable();

                $table->timestamps();

                $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
                $table->foreign('user_pm_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::dropIfExists('projects');
    }
}
