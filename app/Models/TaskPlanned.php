<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TaskPlanned extends Model {
    //
    public function project(){

        return $this->belongsTo(Project::class, 'project_id');
    }
//    public static function createOrUpdateTaskPlanned($task_id,$project_id,$uuid,$startTime,$endTime){
//        $task =  TaskPlanned::where('uuid','=',$uuid)->first();
//        if(!$task){
//            $task = new TaskPlanned;
//            $task->project_id = $project_id;
//            $task->uuid = $uuid;
//        }
//
//
//
//
//       // $task->task_id = $task_id;
//        $task->time_start = $startTime;
//        $task->time_end = $endTime;
//
//        $task->save();
//    }
    public static function createOrUpdateTaskPlanned(Company $company, $project_id,$day,$slot,$user_id,$creator_id){


        $task =  TaskPlanned::where('slot_number','=',$slot)
            ->where('user_id','=',$user_id)
            ->where('day_date','=',$day)
            ->first();

        if(!$task ){

            if( $project_id == 0){
                return false;
            }
            $task = new TaskPlanned;
            $task->project_id = $project_id;
            $task->company_id = $company->id;
            $task->user_id = $user_id;
            $task->added_by = $creator_id;

        }else{
            // -- if project id is  00  remove the task
            if($project_id == 0){
                $task->delete();
                return;
            }
        }



        $task->day_date = $day;
        $task->slot_number = $slot;

        $task->save();
    }
}
