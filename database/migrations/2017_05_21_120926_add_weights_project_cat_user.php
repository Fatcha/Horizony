<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWeightsProjectCatUser extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('company_user', function (Blueprint $table) {
            $table->unsignedInteger('view_weight')->default(5)->after('role');
        });

        Schema::table('project_categories', function (Blueprint $table) {
            $table->unsignedInteger('view_weight')->default(5)->after('color');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedInteger('view_weight')->default(5)->after('color');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->unsignedInteger('view_weight')->default(5)->after('company_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('company_user', function (Blueprint $table) {
            $table->dropColumn('view_weight');
        });

        Schema::table('project_categories', function (Blueprint $table) {
            $table->dropColumn('view_weight');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('view_weight');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('view_weight');
        });
    }
}
