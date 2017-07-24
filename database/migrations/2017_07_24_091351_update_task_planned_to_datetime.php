<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTaskPlannedToDatetime extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        if (!Schema::hasColumn('task_planneds', 'start_datetime')) {
            Schema::table('task_planneds', function (Blueprint $table) {
                $table->text('start_datetime')->nullable()->after('day_date');
                $table->text('end_datetime')->nullable()->after('start_datetime');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (Schema::hasColumn('task_planneds', 'start_datetime')) {
            Schema::table('task_planneds', function (Blueprint $table) {
                $table->dropColumn('start_datetime');
                $table->dropColumn('end_datetime');
            });
        }
    }
}
