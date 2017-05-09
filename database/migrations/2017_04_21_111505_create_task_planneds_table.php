<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskPlannedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_planneds', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('task_id')->unsigned()->nullable();

            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->dateTime('time_start')->nullable();
            $table->date('day_date')->nullable();
            $table->tinyInteger('slot_number')->nullable();
            $table->smallInteger('duration')->unsigned()->nullable();
            $table->string('uuid',50)->unique();



            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['company_id', 'user_id','slot_number','day_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_planneds');
    }
}
