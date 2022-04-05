<style>
    .input_invisible {
        background-color: transparent !important;
    }

    .text-white {
        color: white !important;
    }

    .size-sm {
        width: 6rem !important;
    }

    input,
    select {
        background-color: transparent;
        text-align: center;
        border: transparent;
        color: black;
    }
</style>
<!-- Breadcrumb -->
<section class="breadcrumb" ng-app='plannerApp' ng-controller='planController'>
    <h1><?= $title ?></h1>
    <ul>
    <li><a href= "<?php echo base_url(); ?>index.php" >Home</a></li>
        <li class="divider la la-arrow-right"></li>
        <li><?= $title ?></li>
    </ul>
    <form method="POST" enctype="multipart/form-data">
        <div style="display:flex; justify-content: flex-end;">
            <button type="button" ng-click="copy_clipboard()" class="btn btn-icon btn-icon_large btn_info uppercase" data-toggle="tooltip" data-tippy-content="Paste the information of the excel table" data-tippy-placement="right" aria-expanded="false"> <span class="las la-paste"></span>
            </button>
        </div>
        <table class="table table_bordered w-full mt-3">
            <thead class="text-xs">
                <tr>

                    <th scope="col" class="bg-[#D1FAE5]"><small>PLANT:</small></th>
                    <th scope="col">
                        <input type="text" name="" value="" ng-model="production_plan.plant_name" disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>AREA:</small></th>
                    <th scope="col">
                        <input type="text" name="" value="" ng-model="production_plan.site_name" disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>OUTPUT:</small></th>
                    <th scope="col">
                        <input type="text" name="" value="" ng-model="production_plan.asset_name" disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>SHIFT:</small></th>
                    <th scope="col">
                        <input type="text" name="shift_id" ng-model="production_plan.shift_id" class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>HC:</small></th>
                    <th scope="col">
                        <input type="number" min="1" name="hc" id="" onkeyup="" ng-model="production_plan.hc" ng-change="sethc()" class="form-control input_invisible size-sm" />
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>DATE:</small></th>
                    <th scope="col">
                        <input style="min-width: 10rem; border: 0;" name="date" ng-model="production_plan.date_display" class="form-control input_invisible size-sm" type="date">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>SUPERVISOR:</small></th>
                    <th scope="col">
                        <input type="text" name="supervisor_id" value="" class="form-control input_invisible size-sm">
                    </th>
                </tr>
            </thead>
        </table>
        <div style="display: flex; justify-content:flex-end;">
            <div class=" my-3 px-5 text-right mt-3">
                <input class="form-check-input mt-1" id="flexCheckDefault" ng-model="production_plan.use_multiplier_factor" type="checkbox" value="">
                <label class="form-check-label px-3 mt-0" for="flexCheckDefault">Factor multiplicador</label>
                <input class="form-control" style="width: 12rem;" type="number" min="1" ng-model="production_plan.multiplier_factor" ng-disabled="!production_plan.use_multiplier_factor" value="1" id="">
            </div>
        </div>
        <div>
            <table class="table table_bordered w-full mt-3 text-center">
                <thead>
                    <tr class="bg-[#059669]">
                        <th scope="col" class="text-white text-xs">HR</th>
                        <th scope="col" class="text-white text-xs">HC</th>
                        <th scope="col" class="text-white text-xs">ITEM NUMBER</th>
                        <th scope="col" class="text-white text-xs">WO NUMBER</th>
                        <th scope="col" class="text-white text-xs">PLAN BY HR</th>
                        <th scope="col" class="text-white text-xs">CUM PLAN</th>
                        <th scope="col" class="text-white text-xs">PLANNED INTERRUPTION</th>
                        <th scope="col" class="text-white text-xs">LESS TIME</th>
                        <th scope="col" class="text-white text-xs">STD TIME</th>
                        <th scope="col" class="text-white text-xs">
                            CALCULATED QTY BY HR <br />
                            (HC - LESS TIME) / STD TIME
                        </th>
                    </tr>
                </thead>
                <tbody class="text-center">


                    <tr ng-repeat="plan_item in production_plan.plan_by_hours">
                        <!-- 6:00-7:00am -->
                        <th style="min-width: 7rem;" class="bg-[#D1FAE5] text-xs">{{plan_item.time_display | date:'hh:mm'}}-{{plan_item.time_end_display | date:'hh:mm'}} {{ plan_item.time_display.getHours() >= 12  ? 'pm' : 'am'}}</th>

                        <!-- HC -->
                        <td id="" class="bg-[#D1FAE5]">
                            <input type="number" min="1" type="text" name="" onkeyup="" class="form-control input_invisible size-sm" ng-model="plan_item.planned_head_count" ng-change="hc_changed(plan_item)" />
                        </td>

                        <!-- ITEM NUMBER -->
                        <td>
                            <input placeholder="Select" type="text" ng-model="plan_item.item_number" ng-change="partnumber_changed(plan_item)" class="form-control input_invisible size-sm" list="dl_items" required />
                        </td>

                        <!-- WORKORDER  -->
                        <td><input type="text" name="" ng-model="plan_item.workorder" class="form-control input_invisible size-sm"></td>

                        <!-- PLAN BY HOUR -->
                        <td id=""><input type="number" min="0" onkeyup="" ng-model="plan_item.planned" ng-change="planned_changed(plan_item)" class="form-control input_invisible size-sm" /></td>


                        <!-- CUM PLAN -->
                        <td id="" name="" class="bg-[#D1FAE5] form-control size-sm">
                            <input type="number" min="0" ng-model="plan_item.planned_acum" class="form-control input_invisible size-sm" disabled>
                        </td>

                        <!-- PLANNED INTERRUPTION -->
                        <td>
                            <select class="form-control input_invisible" ng-model="plan_item.selected_interruption" ng-change="interruption_changed(plan_item)" ng-options="interruption as interruption.interruption_name for interruption in interruptions">
                                <option value="" ng-if="false"></option>
                            </select>
                        </td>

                        <!-- LESS TIME -->
                        <td class="bg-[#D1FAE5] form-control size-sm" id="">
                            <input class="size-sm" type="number" ng-model="plan_item.less_time" name="" id="" disabled="true">
                        </td>

                        <!-- STD TIME -->
                        <td class="bg-[#D1FAE5] form-control size-sm" id="">
                            <input class="size-sm" type="number" name="" id="" ng-model="plan_item.std_time" disabled="true">
                        </td>

                        <!-- CALCULATED QTY BY HR -->
                        <td class="bg-[#D1FAE5] form-control size-sm" id="">
                            <input class="size-sm" type="text" name="" id="" disabled="true" ng-model="plan_item.formula">
                        </td>
                    </tr>

                    <datalist id="dl_items">
                        <option ng-repeat='item in items' value="{{item.item_number}}"></option>
                    </datalist>

                </tbody>
            </table>
            <div class="flex justify-end mt-5">
                <button type="button" class="btn btn_success uppercase" ng-click="save()">
                    <span class="la la-save ltr:mr-2 rtl:ml-2"></span>
                    Save Plan
                </button>
            </div>
        </div>



    </form>
</section>

<script>
    /*
     * Author: Emanuel Jauregui
     * Date: 04/04/2022  
     * $scope.production_plan is the object that contains all the data for this screen, is the core of the funcionality.
     * 
     *  each row is represented by an array called  $scope.production_plan.plan_by_hours
     *  each plan_by_hours contains:
     * planned_head_count: is the hc for each row, it is allowed modify them individually
     * item_number: it is the identifier for the part (it is the part number)
     * workorder: the number of work order, for 
     * planned: is the planned production for that hour for traceability purposes
     */
    var fetch = angular.module('plannerApp', []);
    fetch.controller('planController', ['$scope', '$http', function($scope, $http) {

        //El plan de produccion
        $scope.production_plan = null;

        //La lista de items (item_number, etc..)
        $scope.items = null;

        //Lista de interrupciones
        $scope.interruptions = null;

        $scope.init = function(asset_id, shift_id, date) {
            $scope.shift_id = shift_id;
            $scope.asset_id = asset_id;
            $scope.date = date;

            $scope.getInterruptions();
            $scope.getPlan();
            $scope.getItems();
        }

        $scope.getPlan = function() {
            $http({
                method: 'get',
                url: '<?= base_url() ?>index.php/api/plan/get',
                params: {
                    asset_id: $scope.asset_id,
                    shift_id: $scope.shift_id,
                    date: $scope.date
                }
            }).then(function successCallback(response) {

                console.log(response.data);

                $scope.production_plan = response.data;
                $scope.production_plan.date_display = new Date(response.data.date);

                for (var i = 0; i < $scope.production_plan.plan_by_hours.length; i++) {
                    var plan_item = response.data.plan_by_hours[i];
                    plan_item.time_display = new Date(response.data.plan_by_hours[i].time);
                    plan_item.time_end_display = new Date(response.data.plan_by_hours[i].time_end);

                    //Estos numeros necesitan estar definidos como numteros
                    //console.log($scope.production_plan.plan_by_hours[i].planned_head_count);
                    if ($scope.production_plan.plan_by_hours[i].planned_head_count == null)
                        plan_item.planned_head_count = undefined;
                    else
                        plan_item.planned_head_count = Number($scope.production_plan.plan_by_hours[i].planned_head_count);

                    if ($scope.production_plan.plan_by_hours[i].planned == null)
                        plan_item.planned = undefined;
                    else
                        plan_item.planned = Number($scope.production_plan.plan_by_hours[i].planned);

                    if ($scope.production_plan.plan_by_hours[i].std_time == null)
                        plan_item.std_time = undefined;
                    else
                        plan_item.std_time = Number($scope.production_plan.plan_by_hours[i].std_time);

                    if ($scope.production_plan.plan_by_hours[i].less_time == null)
                        plan_item.less_time = undefined;
                    else
                        plan_item.less_time = Number($scope.production_plan.plan_by_hours[i].less_time);
                    //plan_item.interruption_id = plan_item.selected_interruption.interruption_id;
                }




            });
        }

        $scope.getItems = function() {
            $http({
                method: 'get',
                url: '<?= base_url() ?>index.php/api/items/get',
            }).then(function successCallback(response) {
                console.log(response.data);
                $scope.items = response.data.items;
                $scope.updateItems();
            });
        }


        $scope.updateItems = function() {

            for (var i = 0; i < $scope.production_plan.plan_by_hours.length; i++) {

                $scope.production_plan.plan_by_hours[i].interruption_id = Number($scope.production_plan.plan_by_hours[i].interruption_id);
                var foundInterruption = $scope.interruptions.filter(function(interr) {
                    return Number(interr.interruption_id) === $scope.production_plan.plan_by_hours[i].interruption_id;
                })[0];
                if (foundInterruption)
                    $scope.production_plan.plan_by_hours[i].selected_interruption = foundInterruption;

                if ($scope.production_plan.plan_by_hours[i].item_id != undefined) {
                    var found = $scope.items.filter(function(item) {
                        return item.item_id === $scope.production_plan.plan_by_hours[i].item_id;
                    })[0];

                    if (found) {
                        $scope.production_plan.plan_by_hours[i].item_number = found.item_number;
                        $scope.calculate_formula($scope.production_plan.plan_by_hours[i]);
                    }
                }
            }

            $scope.update_acum();

        }

        $scope.getIdFromItemNumber = function(item_number) {
            var found = $scope.items.filter(function(item) {
                return item.item_number === item_number;
            })[0];

            if (found) {
                return found.item_id;
            } else {
                return null;
            }


        }


        $scope.getInterruptions = function() {
            $http({
                method: 'get',
                url: '<?= base_url() ?>index.php/api/interruptions/get',
            }).then(function successCallback(response) {
                $scope.interruptions = response.data.interruptions;
                console.log($scope.interruptions);
            });
        }


        $scope.getInterruptionFromName = function(interruption_name) {
            //console.log('load interuption ' + $scope.interruptions);
            var found = null;
            for (let i = 0; i < $scope.interruptions.length; i++) {
                console.log($scope.interruptions[i].interruption_name);
                if ($scope.interruptions[i].interruption_name.trim() === interruption_name.trim()) {
                    found = $scope.interruptions[i];
                    break;
                }
            }

            if (found) {
                return found;
            } else {
                return null;
            }
        }

        $scope.sethc = function() {
            console.log('hc: ' + $scope.production_plan.hc)
            for (var i = 0; i < $scope.production_plan.plan_by_hours.length; i++) {
                $scope.production_plan.plan_by_hours[i].planned_head_count = $scope.production_plan.hc;
            }
        }

        $scope.partnumber_changed = function(plan_item) {

            var found = $scope.items.filter(function(item) {
                return item.item_number === plan_item.item_number;
            })[0];

            if (found) {
                plan_item.item_id = found.item_id;
                plan_item.std_time = parseFloat(found.item_run_labor);
                $scope.calculate_formula(plan_item);
                //console.log('item_id loaded...')
            } else {
                console.log('not found item');
                plan_item.item_id = undefined;
                plan_item.std_time = undefined;
                $scope.calculate_formula(plan_item);
            }
        }


        $scope.planned_changed = function(plan_item) {
            $scope.calculate_formula(plan_item);
            $scope.update_acum();
        }

        $scope.update_acum = function() {
            var count = $scope.production_plan.plan_by_hours.length;
            var total = 0;
            for (let i = 0; i < count; i++) {
                //$scope.production_plan.plan_by_hours[i].planned_acum = $scope.production_plan.plan_by_hours[i].planned;
                total += $scope.production_plan.plan_by_hours[i].planned;
                $scope.production_plan.plan_by_hours[i].planned_acum = total;
            }
        }

        $scope.hc_changed = function(plan_item) {
            $scope.calculate_formula(plan_item);
        }


        $scope.interruption_changed = function(plan_item) {
            plan_item.interruption_id = plan_item.selected_interruption.interruption_id;
            plan_item.less_time = parseFloat(plan_item.selected_interruption.interruption_time);
        }


        $scope.calculate_formula = function(plan_item) {
            //console.log("calculate formula....")
            //console.log(plan_item);

            if (plan_item == undefined)
                return;

            if (plan_item.planned == undefined || plan_item.std_time == undefined) {
                plan_item.formula = undefined;
            } else {
                plan_item.formula = parseFloat((plan_item.planned_head_count - (plan_item.less_time == undefined ? 0 : plan_item.less_time)) / plan_item.std_time).toFixed(2);
            }
        }


        /* Author: Emanuel Jauregui
         * Date: 04/04/2022
         * Last Update: 04/04/2022
         * 
         * Method: save
         * Parameters: None
         * $scope.production_plan Represents all the production plan of the entire screen
         * $scope.production_plan.plan_by_hours represents each row of the plan, the row containing the Date (start - end date)
         *  the method send to the api a json string of the $scope.production_plan to be stored.   
         *  It will have a validation for not completed rows based on HC, item_number, work order and plany by hours
         */
        $scope.save = function() {

            for (let i = 0; i < $scope.production_plan.plan_by_hours.length; i++) {

                //Si al menos uno tiene definidos datos
                if ($scope.production_plan.plan_by_hours[i].planned != undefined ||
                    $scope.production_plan.plan_by_hours[i].item_id != undefined ||
                    $scope.production_plan.plan_by_hours[i].workorder != undefined ||
                    $scope.production_plan.plan_by_hours[i].planned_head_count != undefined
                ) {

                    //Checar que esten definidos los 4 datos       
                    if (!
                        ($scope.production_plan.plan_by_hours[i].planned != undefined &&
                            $scope.production_plan.plan_by_hours[i].item_id != undefined &&
                            $scope.production_plan.plan_by_hours[i].workorder != undefined &&
                            $scope.production_plan.plan_by_hours[i].planned_head_count != undefined
                        )
                    ) {
                        //plan_item.time_display
                        swal("Something was wrong!", "You have some data incompleted! check item number, workorder, hc and planned from row with time: " + $scope.production_plan.plan_by_hours[i].time_display.getHours() + ":00", "error");
                        return;
                    }
                }
            }
            //if($scope.production_plan.plan_by_hours[i]

            var url = '<?= base_url() ?>index.php/api/plan/save';
            var data = {
                plan: $scope.production_plan
            }
            var config = {
                headers: {
                    'Content-Type': 'application/json'
                }
            }
            $http.post(url, data, config).then(function(response) {

                console.log(response);
                swal("Good job!", "The plan has been saved.", "success");
            }, function(response) {

                // this function handles error
            });
        }


        $scope.copy_clipboard = function() {

            console.log('entering to copy clipboard');

            const column_hc = 1;
            const column_item_number = 2;
            const column_workorder = 3;
            const plan_by_hour = 4;
            const planned_interuption = 5;

            (async () => {


                var text = await navigator.clipboard.readText();
                //console.log(text);

                var lines = text.split("\n");

                let table_row = 0;

                for (let i = 1; i < lines.length; i++) {
                    //console.log('goes beyond all lines');

                    var line = lines[i];
                    if (line == '') {
                        //console.log('arrived here');
                        break;
                    }


                    var rows = line.split("\t");

                    //console.log(rows);
                    $scope.production_plan.plan_by_hours[table_row].planned_head_count = Number(rows[column_hc]);

                    $scope.production_plan.plan_by_hours[table_row].item_number = rows[column_item_number];
                    $scope.partnumber_changed($scope.production_plan.plan_by_hours[table_row]);

                    $scope.production_plan.plan_by_hours[table_row].workorder = rows[column_workorder];
                    $scope.production_plan.plan_by_hours[table_row].planned = Number(rows[plan_by_hour]);

                    console.log('buscar ' + rows[planned_interuption]);
                    $scope.production_plan.plan_by_hours[table_row].selected_interruption = $scope.getInterruptionFromName(rows[planned_interuption]);

                    if ($scope.production_plan.plan_by_hours[table_row].selected_interruption != null) {
                        console.log('found interruption changed');
                        $scope.production_plan.plan_by_hours[table_row].interruption_id = $scope.production_plan.plan_by_hours[table_row].selected_interruption.interruption_id;
                        $scope.interruption_changed($scope.production_plan.plan_by_hours[table_row]);
                    }

                    $scope.calculate_formula();

                    table_row++;
                }
                $scope.update_acum();
                $scope.$apply();

            })();
        }

        //este es al cargar
        $scope.init(<?php echo $asset_id . ", " . $shift_id . ", '" . $date . "'" ?>);
    }]);
</script>