<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColorProject extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        if (!Schema::hasColumn('projects', 'color')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->string('color', 10)->nullable()->after('user_pm_id');

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (Schema::hasColumn('projects', 'color')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('color');

            });
        }
    }
}
