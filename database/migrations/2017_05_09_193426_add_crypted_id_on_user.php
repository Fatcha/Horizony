<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCryptedIdOnUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('users', 'crypted_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('crypted_id',60)->nullabe()->default(null)->unique()->after('password');

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
        if (Schema::hasColumn('users', 'crypted_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('crypted_id');

            });
        }
    }
}
