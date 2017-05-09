<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectCategoriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {


        Schema::create('project_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150)->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->string('color',10)->nullable();

            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->nullable()->after('job_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('project_categories');
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('category_id');

        });
    }
}
