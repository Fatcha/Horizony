@extends('layouts.app')


@section('content')


    <div id="planning-view">
        <table class="table">
            <thead>


            <tr class="">
                <th>

                </th>
                @foreach($arrayDate as $date)
                    <th colspan="8">
                        <div class="date-header">
                            {{$date->format('d-m-Y')}}
                        </div>
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($departments as $department)
                <tr class="date-header">
                    <td> {{$department->name}}</td>
                </tr>
                @foreach($department->users as $user)
                    <tr>
                        <td>  {{$user->name}}</td>
                        @foreach($arrayDate as $date)
                            <td class="{{ $date->isWeekend() ? 'bg-danger':''  }} day droppable" data-date="{{$date->format('Y-m-d')}}" data-user-id="{{$user->id}}">
                               <!-- <table class="user-day">
                                    <tr>-->
                                @for($i =0 ; $i< 8 ;$i++)
                                    <td class="slot {{ $date->isWeekend() ? 'bg-danger':''  }} day droppable" data-date="{{$date->format('Y-m-d')}} " style="height:10px; width:14px; border: 1px solid #999; padding: 0; margin: 0" data-slot="{{$i}}"> . </td>
                                @endfor
                                    <!--</tr>
                                </table>-->
                           </td>
                        @endforeach
                    </tr>
                @endforeach

            @endforeach
            </tbody>
        </table>

        <div>

            @foreach($projectsArray as $project)
                <div class="label label-success draggable" id="project_{{$project->id}}" data-project-id="{{$project->id}}">{{$project->name}}</div>
            @endforeach
        </div>

    </div>


    <script>

        function generateUUID () { // Public Domain/MIT
            var d = new Date().getTime();
            if (typeof performance !== 'undefined' && typeof performance.now === 'function'){
                d += performance.now(); //use high-precision timer if available
            }
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                var r = (d + Math.random() * 16) % 16 | 0;
                d = Math.floor(d / 16);
                return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
            });
        }

        $( function() {
            $( ".draggable" ).draggable({helper:'clone'});
            $( ".droppable" ).droppable({
                drop: function( event, ui ) {

                    var uuid  = generateUUID();
                    var time_start = $( this ).attr('data-date');
                    var duration = 60;
                    var user_id = $( this ).attr('data-user-id');

                    var element = createElementOnPlanning(ui.draggable.html(),ui.draggable.attr('data-project-id'),uuid,duration);
                    element.css('width',(15*parseInt(duration/60)));
                    $( this )
                        .append(element);


                    createUpdatePlannedTask(ui.draggable.attr('data-project-id'),uuid,time_start,duration,user_id);
                    addResisable(uuid);
                }
            });
            $(document).on( "click",'.remove-project',function(){

                var uuid = $(this).parent().attr('data-uuid');
                removePlannedTask(uuid);
                $(this).parent().remove();
            });

            getAllPlannedTasks();

        } );

        $(function () {
            var isMouseDown = false,
                isHighlighted;
            $("table.user-day td")
                .mousedown(function () {
                    isMouseDown = true;
                    $(this).toggleClass("highlighted");
                    isHighlighted = $(this).hasClass("highlighted");




                    return false; // prevent text selection
                })
                .mouseover(function () {
                    if (isMouseDown) {
                        $(this).toggleClass("highlighted", isHighlighted);
                        if(isHighlighted){
                            var slot = $(this).attr('data-slot');
                            var date = $(this).parent().parent().parent().parent().attr('data-date');
                            var user_id = $(this).parent().parent().parent().parent().attr('data-user-id');
                            var project_id = 1;
                            console.log(date);

                            createUpdatePlannedTask(project_id,date,slot,user_id);
                        }
                    }
                });

            $(document)
                .mouseup(function () {
                    isMouseDown = false;
                });
        });

        function createElementOnPlanning(name,project_id,uuid,duration,project_id){
            //<input type="text" class="duration" value="'+duration+'">
            return $('<div id="'+uuid+'" data-uuid="'+uuid+'" class=" task-planned label-success  draggable resizable on-planning" data-project-id="'+project_id+'" "><div class="background-text">'+name+'</div> &nbsp; <a class="remove-project">x</a></div>');
        }

     /*   function createUpdatePlannedTask(project_id,uuid,time_start,duration,user_id){


            $.ajax({
                url : '<?php echo route('company_planning_create_task_planned',['company_key'=>$company->key]);?>',
                method: "POST",
                data: {'project_id':project_id, 'uuid' : uuid,'slot_number': 0 , 'time_start': time_start, 'duration': duration, 'user_id' :user_id },
                success : function(){

                }
            });
        }*/

        function createUpdatePlannedTask(project_id,day,slot,user_id){
            console.log("Update "+project_id);
            console.log("Update "+day);
            console.log("Update "+slot);
            console.log("Update "+user_id);
            $.ajax({
                url : '<?php echo route('company_planning_create_task_planned',['company_key'=>$company->key]);?>',
                method: "POST",
                data: {'project_id':project_id, 'slot_number': slot , 'time_start': day,  'user_id' :user_id },
                success : function(){

                }
            });
        }

        var plannedTask = [];
        function getAllPlannedTasks(){
            $.ajax({
                url : '<?php echo route('company_planning_get_tasks_planned',['company_key'=>$company->key]);?>',
                method: "POST",
                data: {},
                success : function(result){
                    plannedTask = result;
                    addTaskPlannedOnView();
                }
            });

        }

        function removePlannedTask(uuid){
            $.ajax({
                url : '<?php echo route('company_planning_remove_tasks_planned',['company_key'=>$company->key]);?>',
                method: "POST",
                data: {'uuid' : uuid},
                success : function(result){

                }
            });

        }

        function addTaskPlannedOnView(){
            for(var i=0 ; i< plannedTask.length; i++){
                var currentTaslPlanned = plannedTask[i];
                var element = createElementOnPlanning(currentTaslPlanned.name,currentTaslPlanned.project_id,currentTaslPlanned.uuid,currentTaslPlanned.duration);
                element.css('width',(15*parseInt(currentTaslPlanned.duration/60)));
                console.log(currentTaslPlanned.duration/60);
                $("td[data-date="+currentTaslPlanned.time_start+"][data-user-id="+currentTaslPlanned.user_id+"]" )
                    .append(element);

                addResisable(currentTaslPlanned.uuid)
            }
        }

        function addResisable(id){
            $( "#"+id ).resizable({
                grid:17,
                minHeight: 20,
                maxHeight: 30,
                minWidth: 10,
                maxWidth: 150,
                stop: function( event, ui ) {
                    var project_id  = ui.element.attr('data-project-id');
                    var uuid        = ui.element.attr('data-uuid');
                    var duration    = ui.size.width;
                    var time_start  = ui.element.parent().attr('data-date');
                    var user_id  = ui.element.parent().attr('data-user-id');
                    console.log(project_id);

                    createUpdatePlannedTask(project_id,ui.element.attr('data-uuid'),time_start,duration,user_id);
                }
            });
        }



    </script>



@stop
