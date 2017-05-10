<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix' => 'admin','middleware' => 'auth.admin'], function () {
    Route::get('/', ['uses' => 'Admin\AdminPagesController@dashboard', 'as' => "admin_dashboard"]);


    Route::group(['prefix' => 'users'], function () {

        Route::any('/', ['uses' => 'Admin\AdminUserController@home', 'as' => "admin_user_home"]);
        Route::any('/{id}', ['uses' => 'Admin\AdminUserController@edit', 'as' => "admin_user_edit"]);

    });

    Route::group(['prefix' => 'companies'], function () {

        Route::any('/', ['uses' => 'Admin\AdminCompanyController@home', 'as' => "admin_company_home"]);
        Route::any('/{id}', ['uses' => 'Admin\AdminCompanyController@edit', 'as' => "admin_company_edit"]);

    });

    Route::group(['prefix' => 'paypal'], function () {

        Route::any('/create', ['uses' => 'Admin\Paypal\PaypalController@createPlan', 'as' => "admin_paypal_create_plan"]);
        Route::any('/active', ['uses' => 'Admin\Paypal\PaypalController@activePlan', 'as' => "admin_paypal_active_plan"]);
        Route::any('/list/{status?}', ['uses' => 'Admin\Paypal\PaypalController@listPlans', 'as' => "admin_paypal_list_plans"]);
        Route::any('/delete', ['uses' => 'Admin\Paypal\PaypalController@deletePlan', 'as' => "admin_paypal_delete_plan"]);
        Route::any('/agreement', ['uses' => 'Admin\Paypal\PaypalController@createAgreement', 'as' => "admin_paypal_create_agreement"]);

    });

    Route::group(['prefix' => 'accounts'], function () {
        Route::any('/', ['uses' => 'Admin\AdminAccountController@home', 'as' => "admin_account_home"]);
        Route::any('/edit/{id}', ['uses' => 'Admin\AdminAccountController@edit', 'as' => "admin_account_edit"]);

    });
});

/*
  |--------------------------------------------------------------------------
  | Registration   Routes
  |--------------------------------------------------------------------------
 */
Route::group(['prefix' => 'register'], function () {
    Route::group(['prefix' => 'company'], function () {

        Route::get('/', ['uses' => 'RegisterController@form', 'as' => "register_company"]);
        Route::post('/save', ['uses' => 'RegisterController@save', 'as' => "register_save"]);
    });
});
/*
  |--------------------------------------------------------------------------
  | Company  Routes
  |--------------------------------------------------------------------------
 */
Route::group(['prefix' => 'company'], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/', array('as' => 'company_user_list', 'uses' => 'CompanyController@listCompanies'));
    });
});

Route::group(['prefix' => 'c/{company_key}'], function () {
    Route::group(['middleware' => ['auth']], function () {

        Route::get('/', array('as' => 'company_home', 'uses' => 'CompanyController@home'));
        Route::group(['prefix' => 'test'], function () {
            Route::get('send', array('as' => 'company_send_test', 'uses' => 'CompanyController@sendTestForm'));
            Route::post('send/save', array('as' => 'company_send_test_save', 'uses' => 'CompanyController@sendTestSave'));
        });


        Route::group(['prefix' => 'planning'], function () {
            Route::get('/', array('as' => 'company_planning', 'uses' => 'PlanningController@view'));
          //  Route::post('/createOrupdateTaskPlanned', array('as' => 'company_planning_create_task_planned', 'uses' => 'PlanningController@updateoOrCreatePlannedtask'));
            Route::post('/createOrupdateTaskPlanned', array('as' => 'company_planning_update_multiple_tasks_planned', 'uses' => 'PlanningController@updateOrCreateMultiplePlannedTasks'));
            Route::post('/getPlannedTask', array('as' => 'company_planning_get_tasks_planned', 'uses' => 'PlanningController@getPlannedTasks'));
            Route::post('/task/remove', array('as' => 'company_planning_remove_tasks_planned', 'uses' => 'PlanningController@removePlannedTasks'));

        });

        Route::group(['prefix' => 'project'], function () {
            Route::any('/edit/{cid?}', array('as' => 'company_project_edit', 'uses' => 'ProjectController@edit'));
            Route::any('/cat/edit/{cid?}', array('as' => 'company_project_cat_edit', 'uses' => 'ProjectController@editCategory'));
        });

        Route::group(['prefix' => 'department'], function () {
            Route::any('/edit/{cid?}', array('as' => 'company_department_create_or_update', 'uses' => 'CompanyController@editDepartment'));

        });

        Route::group(['prefix' => 'member'], function () {
            Route::post('invite', array('as' => 'company_invite_member', 'uses' => 'CompanyController@inviteMemberOnCompany'));
            Route::get('delete/{userCid}', array('as' => 'company_delete_member', 'uses' => 'CompanyController@deleteMemberOnCompany'));
        });

        Route::group(['prefix' => 'account'], function () {
            Route::get('/', array('as' => 'company_account_home', 'uses' => 'CompanyController@account'));
            Route::get('/change/do/{accountKey}', array('as' => 'company_account_do_change', 'uses' => 'CompanyController@doChange'));
        });

    });
});

/*
  |--------------------------------------------------------------------------
  | Connection  Routes
  |--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', array('as' => 'connected_dashboard', 'uses' => 'CompanyController@listCompanies'));
});

Route::get('/connect/{sha_id}/{sha1_crypted_id}', ['uses' => 'Auth\LoginController@connectWithCryptedId', 'as' => "connect_with_crypted_id"]);

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');


