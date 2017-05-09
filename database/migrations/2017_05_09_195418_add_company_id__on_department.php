<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdOnDepartment extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        if (!Schema::hasColumn('departments', 'company_id')) {
            Schema::table('departments', function (Blueprint $table) {
                $table->unsignedInteger('company_id')->nullable()->after('name');
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
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
        if (Schema::hasColumn('departments', 'company_id')) {
            Schema::table('departments', function (Blueprint $table) {
                $table->dropColumn('company_id');

            });
        }
    }
}
