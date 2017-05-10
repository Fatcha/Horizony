<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionTask extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        if (!Schema::hasColumn('task_planneds', 'description')) {
            Schema::table('task_planneds', function (Blueprint $table) {
                $table->text('description')->nullable()->after('slot_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (Schema::hasColumn('task_planneds', 'description')) {
            Schema::table('task_planneds', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
}
