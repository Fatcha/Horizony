<?php

use Illuminate\Database\Seeder;
use App\Models\AccountType;
use App\Models\Company;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Eloquent::unguard();

        $arrayAccounts = AccountType::ACCOUNT_TYPE;

        foreach ($arrayAccounts as $accountType){
            $account = AccountType::where('key_name','=',$accountType['key_name'])->first();

            if(!$account){

                $account = new AccountType();
                $account->key_name = $accountType['key_name'];
                $account->real_price = $accountType['real_price'];
                $account->max_tests_in_progress = $accountType['max_tests'];
                $account->users_limit = $accountType['users_limit'];
                $account->save();
            }
        }

        $companies = Company::whereNull('account_type')->get();
        foreach ($companies as $company){
            $company->account_type = AccountType::ACCOUNT_FREE_KEY;
            $company->save();
        }
        $this->command->info('Account  table seeded!');


    }
}
