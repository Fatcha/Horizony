<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('account_type')) {
            Schema::create('account_type', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->string('key_name', 10)->unique()->nullable();
                $table->float('real_price', 6, 2);
                $table->tinyInteger('max_tests_in_progress');

                $table->timestamps();
            });
        }

        if (!Schema::hasTable('account_type_translation')) {
            Schema::create('account_type_translation', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');

                $table->integer('account_id')->unsigned()->nullable();

                $table->text('name')->nullable();
                $table->float('price', 6, 2)->nullable();
                $table->string('locale', 2)->nullable();

                $table->timestamps();

                $table->unique(['account_id', 'locale']);
                $table->foreign('account_id')->references('id')->on('account_type')->onDelete('cascade');
            });
        }
        if (!Schema::hasTable('account_buying')) {
            Schema::create('account_buying', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');

                $table->string('account_type', 10)->nullable();
                $table->unsignedInteger('company_id');
                $table->dateTime('start_date')->index()->nullable();
                $table->dateTime('end_date')->index()->nullable();

                $table->timestamps();

                $table->foreign('account_type')->references('key_name')->on('account_type')->onDelete('cascade');
                $table->foreign('company_id')->references('id')->on('companies');
            });
        }

        // -- ad account_valid date & account_type
        if (!Schema::hasColumn('companies', 'account_type')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->string('account_type', 10)->nullable()->after('country_code');
                $table->integer('account_valid_date')->dateTime()->nullable()->after('account_type');

                $table->foreign('account_type')->references('key_name')->on('account_type')->onDelete('cascade');
            });
        }

//        if (!Schema::hasColumn('quiz', 'available_in_free')) {
//            Schema::table('quiz', function (Blueprint $table) {
//                $table->tinyInteger('available_in_free')->default(0)->after('active');
//
//            });
//        }
//        if (!Schema::hasColumn('quiz_questions', 'available_in_free')) {
//            Schema::table('quiz_questions', function (Blueprint $table) {
//                $table->tinyInteger('available_in_free')->default(0)->after('active');
//
//            });
//        }




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
//        if (Schema::hasColumn('quiz', 'available_in_free')) {
//            Schema::table('quiz', function (Blueprint $table) {
//                $table->dropColumn('available_in_free');
//
//            });
//        }
//        if (Schema::hasColumn('quiz_questions', 'available_in_free')) {
//            Schema::table('quiz_questions', function (Blueprint $table) {
//                $table->dropColumn('available_in_free');
//
//            });
//        }

        if (Schema::hasColumn('companies', 'account_type')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->dropForeign(['account_type']);

                $table->dropColumn('account_type');
                $table->dropColumn('account_valid_date');
            });
        }
        if (Schema::hasTable('account_type')) {


            Schema::drop('account_buying');
            Schema::drop('account_type_translation');
            Schema::drop('account_type');
        };



    }
}
