@extends('layouts.app')


@section('content')


    <div id="planning-view">
        <div>
            {{$company->name}}
        </div>

        <div id="calendar-view">
            <div id="calendar-container">
                <div class="">
                    <div class="date-header-first">
                        Date:
                    </div>
                    @foreach($arrayDate as $date)

                        <div class="date-header {{ $date->format('d-m-Y') == date("d-m-Y") ? 'today' : ''}}">
                            {{$date->format('d-m-Y')}}
                        </div>

                    @endforeach
                    <div class="clear"></div>
                </div>

                <div class="department-all-row">
                    @foreach($departments as $department)
                        <div class="department-name">
                            <div>  {{$department->name}}</div>
                        </div>
                        @foreach($department->users as $user)
                            <div class="user-row">
                                <div class="user-name">
                                    <div class="small">{{$user->name}}</div>
                                </div>
                            @foreach($arrayDate as $date)
                                <!--  <td class="{{ $date->isWeekend() ? 'bg-danger':''  }} day droppable" data-date="{{$date->format('Y-m-d')}}" data-user-id="{{$user->id}}">
                               <!-- <table class="user-day">
                                    <tr>-->
                                    @for($i =0 ; $i< 8 ;$i++)
                                        <div class="slot {{$i==7 ?'slot-last-of-day':''}} {{ $date->isWeekend() ? 'bg-danger':''  }}  droppable"
                                             data-user-id="{{$user->id}}"
                                             data-date="{{$date->format('Y-m-d')}}"
                                             data-slot="{{$i}}"
                                             data-project-id=""
                                             title="We ask for your age only for statistical purposes."
                                        ></div>
                                    @endfor
                                <!--</tr>
                                </table>-->
                                    <!-- </td>-->

                                @endforeach

                            </div>
                            <div class="clear"></div>
                        @endforeach

                    @endforeach
                </div>
            </div>
        </div>

        <div>
            <button type="button" class="btn btn-danger button-project" data-toggle="button" data-project-id="0"
                    aria-pressed="false" autocomplete="off">
                Erase
            </button>
            @foreach($company->projectsCategories as $category)
                {{$category->name}}
                @foreach($category->projects as $project)

                    <button type="button" class="btn btn-primary button-project" data-toggle="button"
                            id="project_{{$project->id}}"
                            data-project-id="{{$project->id}}"
                            aria-pressed="false"
                            autocomplete="off"
                            data-job-number="{{$project->job_number}}">
                        {{$project->name}}
                    </button>
                @endforeach

            @endforeach

        </div>

    </div>
    <style>
        @foreach($projectsArray as $project)

            [data-project-id="{{$project->id}}"] {
            background-color: {{$project->color}}
        }
        @endforeach
    </style>


    <script>
        var projectIdSelected = 0;


        var slotChangedArray = [];

        function addSlotChanged(element) {
            slotChangedArray.push(element);
        }

        function updateSlotsOnServer() {
            var elementArray = slotChangedArray.slice();
            slotChangedArray = [];
            var stringData = "";
            /*
             *  var slot = $(this).attr('data-slot');
             var date = $(this).parent().parent().parent().parent().attr('data-date');
             var user_id = $(this).parent().parent().parent().parent().attr('data-user-id');
             var project_id = 1;*/
            var objectsArray = [];
            for (var i = 0; i < elementArray.length; i++) {
                var slot = new Object();
                slot.number = elementArray[i].attr('data-slot');
                slot.date_day = elementArray[i].attr('data-date');
                slot.project_id = elementArray[i].attr('data-project-id');
                ;
                slot.user_id = elementArray[i].attr('data-user-id');
                objectsArray.push(slot);
            }

            createUpdatePlannedTask(JSON.stringify(objectsArray));


        }

        function modifySlot($element) {
            var isHighlighted;
            if (projectIdSelected == 0) {

                if ($element.hasClass("highlighted")) {

                    isHighlighted = false;
                    $element.toggleClass("highlighted");
                }
            } else {
                if (!$element.hasClass("highlighted")) {
                    isHighlighted = true;
                    $element.addClass("highlighted");
                } else {
                    return;
                }
            }
            $element.attr("data-project-id", projectIdSelected);

            addSlotChanged($element);

            return isHighlighted;
        }
    @if($company->userIsAdmin(Auth::user()))

        $(function () {

            $(".button-project").click(function () {
                projectIdSelected = $(this).attr("data-project-id");
            });

            var isMouseDown = false,
                isHighlighted;
            $(".slot")
                .mousedown(function () {
                    isMouseDown = true;

                    isHighlighted = modifySlot($(this));


                    //addSlotChanged($(this));


                    return false; // prevent text selection
                })
                .mouseover(function () {
                    if (isMouseDown) {

                        isHighlighted = modifySlot($(this));

                        // addSlotChanged($(this));

                    }
                });

            $(document)
                .mouseup(function () {
                    if (isMouseDown) {
                        updateSlotsOnServer();
                    }
                    isMouseDown = false;

                });



        });


        function createUpdatePlannedTask(tasksJsonString) {

            $.ajax({
                url: '<?php echo route('company_planning_update_multiple_tasks_planned', ['company_key' => $company->key]);?>',
                method: "POST",
                data: {'tasks': tasksJsonString},
                success: function () {
                    getAllPlannedTasks();
                }
            });
        }

        @endif

        $(function(){
            $(document).on('mouseover', '.highlighted', function () {
                console.log("vue");
            });

            getAllPlannedTasks();
            var updateInterval = setInterval(getAllPlannedTasks,'15000');
        });

        var plannedTask = [];
        function getAllPlannedTasks() {
            $.ajax({
                url: '<?php echo route('company_planning_get_tasks_planned', ['company_key' => $company->key]);?>',
                method: "POST",
                data: {},
                success: function (result) {
                    plannedTask = result;
                    addTaskPlannedOnView();
                }
            });

        }

        function addTaskPlannedOnView() {

            for (var i = 0; i < plannedTask.length; i++) {
                var currentTaslPlanned = plannedTask[i];
                var element =

                    $("div[data-date=" + currentTaslPlanned.day + "][data-user-id=" + currentTaslPlanned.user_id + "][data-slot=" + currentTaslPlanned.slot_number + "]")
                        .addClass("highlighted")

                        .attr('data-project-id', currentTaslPlanned.project_id);


            }
        }



    </script>



@stop
