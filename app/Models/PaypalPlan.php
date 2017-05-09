<?php

namespace App\Models;

use App\Models\Quiz\AccountType;
use Illuminate\Database\Eloquent\Model;

class PaypalPlan extends Model
{
    //
    protected $table = 'paypal_plans';

    const STATUS_ARRAY = ['CREATED', 'ACTIVE', 'INACTIVE', 'DELETED'];


    public static function checkPlans($plans){
        if($plans == null) return false;

        foreach ($plans as $plan){
            $existPlan = self::where('paypal_id' ,'=' , $plan->id )->first();
            if(!$existPlan){
                $existPlan = new PaypalPlan();
                $existPlan->paypal_id = $plan->id;
            }

            $existPlan->status = $plan->getState();
            $existPlan->save();

        }

        return true;

    }
}
