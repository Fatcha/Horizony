<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddedBy extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        if (!Schema::hasColumn('task_planneds', 'added_by')) {
            Schema::table('task_planneds', function (Blueprint $table) {
                $table->unsignedInteger('added_by')->nullable()->after('user_id');

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('task_planneds', function (Blueprint $table) {
            $table->dropColumn('added_by');

        });
    }
}
