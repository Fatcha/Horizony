<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Models;


use App\User;
use Illuminate\Support\Facades\App;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Log;

/**
 * Description of DiveEvent
 *
 * @author Brieuc
 */
class Company extends Model {
    //put your code here
    protected $table = 'companies';

    const PENDING_TEST_CONCURRENT_UNLIMITED = 'unlimited';

    const MEMBER_TYPE_ARRAY = ['admin','member'];
    const MEMBER_MANAGER = 'admin';

    public function users() {
        return $this->belongsToMany('App\User')->withPivot('role');
    }

    public function projects() {
        return $this->hasMany(Project::class, 'company_id');
    }

    public function projectsCategories() {
        return $this->hasMany(ProjectCategory::class, 'company_id');
    }

    public function accountType() {
        return $this->belongsTo(AccountType::class, 'account_type', 'key_name');
    }

    public function userIsAdmin(User $user){
        $userExist = $this->users()->where('user_id','=',$user->id)->where('role','=',Company::MEMBER_MANAGER)->first();
        if($userExist){
            return true;
        }
        return false;
    }

    public function userIsMember(User $user){
        $userExist = $this->users()->where('user_id','=',$user->id)->first();
        if($userExist){
            return true;
        }
        return false;
    }

    public function userCanManage(User $user){

        if($this->userIsMember($user) || $this->userIsAdmin($user)){
            return true;
        }

        return false;
    }

    public function getCurrentAccount(){
        return AccountBuying::currentAccountForCompany($this);
    }

    public function getCurrentBuying(){
        return AccountBuying::currentBuyingForCompany($this);
    }




    public function canSendTest() {


        $maxTestsinProgress = $this->getCurrentAccount()->max_tests_in_progress;
        if ($maxTestsinProgress == -1) {
            return true;
        }

        $pendingTestsCount = $this->getNumberOfPendingTests();

        if ($pendingTestsCount >= $maxTestsinProgress) {
            return false;
        }
        return true;

    }

    /**
     * Return the number of allowed tests in the same time. Depends of account type
     * @return string
     */
    public function getNumberOfAllowedPendingTest() {
        $maxTestsinProgress = $this->getCurrentAccount()->max_tests_in_progress;

        if ($maxTestsinProgress == -1) {
            return self::PENDING_TEST_CONCURRENT_UNLIMITED;
        }

        return $maxTestsinProgress;
    }

    public function getNumberOfPendingTests() {
        return 0;
            return $this->pendingTests->count();
    }
//
//    public function sendTestDoneByCandidate($quizUser) {
//
//        foreach ($this->users as $userCompany) {
//            Log::info("send email to " . $userCompany->name);
//            try {
//                Mail::to($userCompany)->send(new TestDonebyUser($quizUser->user, $this, $quizUser));
//            } catch (\Exception $e) {
//                Log::warning('Email notification end test could not be send');
//            }
//        }
//    }




}

?>