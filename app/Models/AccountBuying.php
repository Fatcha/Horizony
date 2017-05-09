<?php

namespace App\Models;

use App\Models\AccountType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AccountBuying extends Model
{
    //
    protected $table = 'account_buying';

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }

    public function accountType(){
        return $this->belongsTo(AccountType::class,'account_type','key_name');
    }


    public static function currentAccountForCompany($company_id){
        //$now = date('Y-D-M H:i:s');

//        $accountBuying = AccountBuying::where('start_date','<=', $now )
//                                        ->where('end_date', '>', $now )
//                                        ->first();
        $accountBuying = AccountBuying::where('start_date','<=', Carbon::now() )
                                        ->where('end_date', '>', Carbon::now() )
                                        ->first();
        if($accountBuying){
            return $accountBuying->accountType;
        }


        return AccountType::getAccountByKey(AccountType::ACCOUNT_FREE_KEY);



    }
    public static function currentBuyingForCompany($company_id){

        $accountBuying = AccountBuying::where('start_date','<=', Carbon::now() )
                                        ->where('end_date', '>', Carbon::now() )
                                        ->first();
        if($accountBuying){
            return $accountBuying;
        }


        return false;



    }



}
