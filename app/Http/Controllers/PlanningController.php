<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\AccountBuying;
use App\Models\AccountType;
use App\Models\Company;
use App\Models\Department;
use App\Models\Fatcha\Crypt\CryptId;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskPlanned;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Auth;
use Mail;


use Illuminate\Http\Request;
use \App\Models\Country;


class PlanningController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Welcome Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders the "marketing page" for the application and
      | is configured to only allow guests. Like most of the other sample
      | controllers, you are free to modify or remove it as you desire.
      |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

    }

    public function view(Request $request, $company_key,$start_date = null,$end_date = null) {


        $company = Company::where('key', '=', $company_key)->first();
        if(!$company){
            return redirect(route('connected_dashboard'));
        }
        // -- test if user can send test for this company
        $user = Auth::user();
        if (!$company->userIsMember(Auth::user())) {
            return redirect(route('connected_dashboard'));
        }

        if($start_date !== null && $end_date !== null ){
            $firstDay = Carbon::createFromFormat('Y-m-d', $start_date);
            $endDay =      Carbon::createFromFormat('Y-m-d', $end_date);;
        }else{


            $firstDay= Carbon::now()->subDay(3);
            $endDay = $firstDay->copy()->addWeeks(2);

        }

        $differenceDays =  $firstDay->diffInDays($endDay) ;

        $arrayDate = [];
        $arrayDate[] = $firstDay;

        for($i=0;$i<$differenceDays;$i++){
            $arrayDate[] = $firstDay->copy()->addDays(($i+1));
        }


        return view('planning.view_jquery', [
            'departments' => $company->departments,
            'isAdmin' => $company->userIsAdmin(Auth::user()),
            'today' => date('H-m-d'),
            'arrayDate' => $arrayDate,
            'projectsArray' => Project::get(),
            'company' => $company,
            'firstday' => $firstDay,
            'endate' => $endDay,
        ]);
    }

    public function getPlanning(Request $request,$company_key){

        $company = Company::where('key', '=', $company_key)->first();
        if(!$company){

            return redirect(route('connected_dashboard'));
        }
        // -- test if user can send test for this company
        $user = Auth::user();
        if (!$company->userIsMember(Auth::user())) {

            return redirect(route('connected_dashboard'));
        }

        $departments = $company->departments;

        $arrayJson = [];

        /** planned tasks */
        $tasks = TaskPlanned::where('company_id','=',$company->id)->get();
        $tasksArray  = [];
        foreach ($tasks as $task){
            $tmpArray = [];
            $tmpArray['id'] = $task->id;
            $tmpArray['project_id'] = $task->project_id;
            $tmpArray['name'] = $task->project->name;

            $tmpArray['slot_number'] = $task->slot_number;
            $tmpArray['day'] = $task->day_date;
            $tmpArray['user_id'] = $task->user_id;;

            $tasksArray[] = $tmpArray;
        }

        $arrayJson['tasks_planned'] = $tasks;

        // -- array date
        $arrayDate = [];
        $now = Carbon::now()->format('d-m-Y');
        $arrayDate[] = $now;

        for($i=0;$i<5;$i++){

            $arrayDate[] = Carbon::now()->addDays(($i+1))->format('d-m-Y');
        }

        $arrayJson['dates'] = $arrayDate;
        // -- user


        $arrayDepartments = [];

        foreach($departments as $department){
            $tmpDepart= [];
            $tmpDepart['cid'] = CryptId::cryptIdToHash($department->id);
            $tmpDepart['name'] = $department->name;
            $tmpDepart['users'] =  [];
            foreach ($department->users as $user){
                $tmpUser =  [];
                $tmpUser['name'] = $user->name;
                $tmpUser['id'] = $user->id;
                $tmpUser['cid'] = CryptId::cryptIdToHash($user->id);
                $tmpDepart['users'][]  = $tmpUser;
            }


            $arrayDepartments[] = $tmpDepart;
        }

        $arrayJson['departments'] = $arrayDepartments;


        return response()
            ->json($arrayJson);


    }

    public function getTasks(Request $request, $company_key,$project_id){
        $tasks = Task::where('project_id','=',$project_id)->get();
        $tasksArray  = [];
        foreach ($tasks as $task){
            $tmpArray = [];
            $tmpArray['id'] = $task->id;
            $tmpArray['name'] = $task->name;

            $tasksArray[] = $tmpArray;
        }

        return response()
            ->json($tasksArray);

    }

    public function getPlannedTasks(Request $request, $company_key){

        $company = Company::where('key', '=', $company_key)->first();
        if(!$company){
            return redirect(route('connected_dashboard'));
        }
        // -- test if user can send test for this company
        $user = Auth::user();
        if (!$company->userIsMember(Auth::user())) {
            return redirect(route('connected_dashboard'));
        }

        $tasks = TaskPlanned::where('company_id','=',$company->id)->get();
        $tasksArray  = [];
        foreach ($tasks as $task){
            $tmpArray = [];
            $tmpArray['id'] = $task->id;
            $tmpArray['project_id'] = $task->project_id;
            $tmpArray['name'] = $task->project->name;

            $tmpArray['slot_number'] = $task->slot_number;
            $tmpArray['day'] = $task->day_date;
            $tmpArray['user_id'] = $task->user_id;;

            $tasksArray[] = $tmpArray;
        }

        return response()
            ->json($tasksArray);

    }

    public function updateOrCreateMultiplePlannedTasks(Request $request, $company_key){


        $company = Company::where('key', '=', $company_key)->first();
        if(!$company){
            return redirect(route('connected_dashboard'));
        }
        // -- test if user can send test for this company
        $user = Auth::user();
        if (!$company->userIsAdmin(Auth::user())) {
            return redirect(route('connected_dashboard'));
        }

        $tasksArray = json_decode($request->input('tasks'));

        foreach($tasksArray as $task){

            TaskPlanned::createOrUpdateTaskPlanned($company,
                $task->project_id,
                $task->date_day,
                $task->number,
                $task->user_id,
                $user->id
            );
        }


    }



//    public function updateoOrCreatePlannedtask(Request $request, $company_key){
//
//
//        $company = Company::where('key', '=', $company_key)->first();
//        if(!$company){
//            return redirect(route('connected_dashboard'));
//        }
//        // -- test if user can send test for this company
//        $user = Auth::user();
//        if (!$company->userIsAdmin(Auth::user())) {
//            return redirect(route('connected_dashboard'));
//        }
//
//
//
//        //createOrUpdateTaskPlanned(Company $company, $task_id,$project_id,$uuid,$day,$slot,$user_id)
//        TaskPlanned::createOrUpdateTaskPlanned($company,'1',
//            $request->input('project_id'),
//            $request->input('time_start'),
//            $request->input('slot_number'),
//            $request->input('user_id')
//        );
//
////        TaskPlanned::createOrUpdateTaskPlanned($company,'1',
////            $request->input('project_id'),
////            $request->input('uuid'),
////            $request->input('time_start'),
////            $request->input('duration'),
////            $request->input('user_id')
////        );
//
//    }
    public function removePlannedTasks(Request $request, $company_key){
        $company = Company::where('key', '=', $company_key)->first();
        if(!$company){
            return redirect(route('connected_dashboard'));
        }
        // -- test if user can send test for this company
        $user = Auth::user();
        if (!$company->userIsAdmin(Auth::user())) {
            return redirect(route('connected_dashboard'));
        }


        TaskPlanned::where('uuid','=',$request->input('uuid'))->delete();

    }



}
