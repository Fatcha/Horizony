<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserRoleLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('users', 'access_level')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('access_level',10)->default('member')->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        if (Schema::hasColumn('users', 'access_level')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('access_level');
            });
        }
    }
}
