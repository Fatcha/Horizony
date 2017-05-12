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

    public function view(Request $request, $company_key) {


        $company = Company::where('key', '=', $company_key)->first();
        if(!$company){
            return redirect(route('connected_dashboard'));
        }
        // -- test if user can send test for this company
        $user = Auth::user();
        if (!$company->userIsMember(Auth::user())) {
            return redirect(route('connected_dashboard'));
        }



        $arrayDate = [];
        $now = Carbon::now();
        $arrayDate[] = $now;

        for($i=0;$i<90;$i++){

            $arrayDate[] = Carbon::now()->addDays(($i+1));
        }

        return view('planning.view', [
            'departments' => $company->departments,
            'isAdmin' => $company->userIsAdmin(Auth::user()),
            'today' => date('H-m-d'),
            'arrayDate' => $arrayDate,
            'projectsArray' => Project::get(),
            'company' => $company,
        ]);
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
