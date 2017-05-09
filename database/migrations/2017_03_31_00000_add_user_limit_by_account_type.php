<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserLimitByAccountType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('account_type', 'users_limit')) {
            Schema::table('account_type', function (Blueprint $table) {
                $table->tinyInteger('users_limit')->nullable()->after('real_price');

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
        if (Schema::hasColumn('account_type', 'users_limit')) {
            Schema::table('account_type', function (Blueprint $table) {
                $table->dropColumn('users_limit');

            });
        }
    }
}
