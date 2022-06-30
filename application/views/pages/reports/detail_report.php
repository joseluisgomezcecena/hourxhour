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

    .red {
        border: solid 1px red;
    }


    .lds-spinner {
        color: official;
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .lds-spinner div {
        transform-origin: 40px 40px;
        animation: lds-spinner 1.2s linear infinite;
    }

    .lds-spinner div:after {
        content: " ";
        display: block;
        position: absolute;
        top: 3px;
        left: 37px;
        width: 6px;
        height: 18px;
        border-radius: 20%;
        background: #000000;
    }

    .lds-spinner div:nth-child(1) {
        transform: rotate(0deg);
        animation-delay: -1.1s;
    }

    .lds-spinner div:nth-child(2) {
        transform: rotate(30deg);
        animation-delay: -1s;
    }

    .lds-spinner div:nth-child(3) {
        transform: rotate(60deg);
        animation-delay: -0.9s;
    }

    .lds-spinner div:nth-child(4) {
        transform: rotate(90deg);
        animation-delay: -0.8s;
    }

    .lds-spinner div:nth-child(5) {
        transform: rotate(120deg);
        animation-delay: -0.7s;
    }

    .lds-spinner div:nth-child(6) {
        transform: rotate(150deg);
        animation-delay: -0.6s;
    }

    .lds-spinner div:nth-child(7) {
        transform: rotate(180deg);
        animation-delay: -0.5s;
    }

    .lds-spinner div:nth-child(8) {
        transform: rotate(210deg);
        animation-delay: -0.4s;
    }

    .lds-spinner div:nth-child(9) {
        transform: rotate(240deg);
        animation-delay: -0.3s;
    }

    .lds-spinner div:nth-child(10) {
        transform: rotate(270deg);
        animation-delay: -0.2s;
    }

    .lds-spinner div:nth-child(11) {
        transform: rotate(300deg);
        animation-delay: -0.1s;
    }

    .lds-spinner div:nth-child(12) {
        transform: rotate(330deg);
        animation-delay: 0s;
    }

    @keyframes lds-spinner {
        0% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }

    .table-success {
        background-color: green;
    }

    .sticky {
        position: sticky !important;
        top: 5rem;
    }
</style>
<!-- Breadcrumb -->
<section class="breadcrumb" ng-app='plannerApp' ng-controller='planController'>
    <h1><?= $title ?></h1>
    <ul>
        <li><a href="<?php echo base_url(); ?>index.php">Home</a></li>
        <li class="divider la la-arrow-right"></li>
        <li><?= $title ?></li>
    </ul>

    <div style="position: absolute; width: 100%; height: 100%;" ng-show="display_loading">
        <div style=" display: flex; justify-content:center">
            <div class="lds-spinner">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

    </div>

    <form method="POST" enctype="multipart/form-data" ng-hide="display_loading">

        <table class="table table_bordered w-full mt-3">
            <thead class="text-xs">
                <tr>
                    <th scope="col" class="bg-[#D1FAE5]"><small>PLANT:</small></th>
                    <th scope="col" style="width:15rem !important;">
                        <select class="form-control size-md" ng-model="selected_plant">
                            <option value="">---select plant---</option>
                            <option ng-repeat="plant in plants" value="{{plant.plant_id}}">{{ plant.plant_name }}</option>
                        </select>
                        <!--<input type="text" name="" value="" ng-model="production_plan.plant_name" disabled class="form-control input_invisible size-sm">-->
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>AREA:</small></th>
                    <th scope="col" style="width:15rem !important;">
                        <select class="form-control size-md" ng-model="selected_site">
                            <option value="">---select sites---</option>
                            <option ng-repeat="site in sites | filter:{plant_id: selected_plant }" value="{{site.site_id}}" ng-show="selected_plant">{{ site.site_name }}</option>
                        </select>
                        <!--<input type="text" name="" value="" ng-model="production_plan.site_name" disabled class="form-control input_invisible size-sm"> -->

                    </th>

                    <th scope="col" class="bg-[#D1FAE5]"><small>OUTPUT:</small></th>
                    <th scope="col" style="width:15rem !important;">
                        <select class="form-control size-md" ng-model="selected_asset">
                            <option value="">---select asset---</option>
                            <option ng-repeat="asset in assets | filter:{site_id: selected_site }" value="{{asset.asset_id}}" ng-show="selected_site">{{ asset.asset_name }}</option>
                        </select>

                        <!--
                        <input type="text" name="" value="" ng-model="production_plan.asset_name" disabled class="form-control input_invisible size-sm">
                        -->
                    </th>



                </tr>

                <tr>


                    <th scope="col" class="bg-[#D1FAE5]"><small>DATE:</small></th>

                    <th scope="col" style="width:15rem !important;">
                        <input style=" border: 0;" name="date" ng-model="selected_date" class="form-control size-md" type="date">
                    </th>


                    <th colspan="2">
                        <button type="button" class="btn btn_success uppercase d-grid gap-2 col-6 mx-5" ng-click="search()" ng-disabled="selected_asset == null || selected_date == null ">
                            <span class="la la-eye ltr:mr-2 rtl:ml-2"></span>
                            Search
                        </button>
                    </th>

                    <th scope="col"><small>SUPERVISOR:</small></th>
                    <th scope="col">
                        <input placeholder="Select" type="text" ng-model="production_plan.supervisor" class="form-control size-md" list="dl_supervisors" readonly />
                    </th>
                    <!-- <th scope="col" style="border-right:solid transparent;">
                    </th> -->


                </tr>

            </thead>
        </table>

        <div>



            <table class="table relative table_bordered w-full mt-3 text-center" ng-if="production_plan.plan_id != null">
                <thead>
                    <tr class="bg-[#059669] sticky my-5">
                        <th scope="col" class="text-white text-xs sticky top-0">HR</th>
                        <th scope="col" class="text-white text-xs sticky top-0">HC</th>
                        <th scope="col" class="text-white text-xs sticky top-0">ITEM NUMBER</th>
                        <th scope="col" class="text-white text-xs sticky top-0">WO NUMBER</th>
                        <th scope="col" class="text-white text-xs sticky top-0">PLAN BY HR</th>
                        <th scope="col" class="text-white text-xs sticky top-0">CUM PLAN</th>

                        <th scope="col" class="text-white text-xs sticky top-0">DONE BY HR</th>
                        <th scope="col" class="text-white text-xs sticky top-0">CUM DONE</th>

                        <th scope="col" class="text-white text-xs sticky top-0">%</th>

                        <th scope="col" class="text-white text-xs sticky top-0">PLANNED INTERRUPTION</th>
                        <th scope="col" class="text-white text-xs sticky top-0">NOT PLANNED INTERRUPTION</th>

                        <!--
                        <th scope="col" class="text-white text-xs sticky top-0">LESS TIME</th>
                        <th scope="col" class="text-white text-xs sticky top-0">STD TIME</th>
                        <th scope="col" class="text-white text-xs sticky top-0">
                            CALCULATED QTY BY HR <br />
                            (HC - LESS TIME) / STD TIME
                        </th>
-->
                    </tr>
                </thead>
                <tbody class="text-center">


                    <tr ng-repeat="plan_item in production_plan.plan_by_hours">
                        <!-- 6:00-7:00am -->
                        <th style="min-width: 7rem;" class="bg-[#D1FAE5] text-xs">{{plan_item.time_display | date:'hh:mm'}}-{{plan_item.time_end_display | date:'hh:mm'}} {{ plan_item.time_display.getHours() >= 12  ? 'pm' : 'am'}}</th>

                        <!-- HC -->
                        <td id="" class="bg-[#D1FAE5] ">
                            <input type="number" min="1" type="text" name="" onkeyup="" class="form-control input_invisible size-sm" ng-model="plan_item.planned_head_count" ng-class="{red: plan_item.invalid_planned_head_count}" ng-change="hc_changed(plan_item)" disabled />
                        </td>

                        <!-- ITEM NUMBER -->
                        <td>
                            <input placeholder="Select" style="text-transform: uppercase;" type="text" ng-model="plan_item.item_number" ng-class="{red: plan_item.invalid_item_id}" ng-change="partnumber_changed(plan_item)" class="form-control input_invisible size-sm" list="dl_items" disabled />
                        </td>

                        <!-- WORKORDER  -->
                        <td>
                            <input type="text" name="" ng-model="plan_item.workorder" ng-class="{red: plan_item.invalid_workorder}" class="form-control input_invisible size-sm" disabled>
                        </td>

                        <!-- PLAN BY HOUR -->
                        <td id=""><input type="number" min="0" onkeyup="" ng-model="plan_item.planned" ng-class="{red: plan_item.invalid_planned}" ng-change="planned_changed(plan_item)" class="form-control input_invisible size-sm" disabled /></td>


                        <!-- CUM PLAN -->
                        <td id="" name="" class="bg-[#D1FAE5] form-control size-sm">
                            <input type="number" min="0" ng-model="plan_item.planned_acum" class="form-control input_invisible size-sm" disabled>
                        </td>


                        <!-- PLAN BY HOUR -->
                        <td id=""><input type="number" min="0" onkeyup="" ng-model="plan_item.completed" ng-class="{red: plan_item.invalid_planned}" class="form-control input_invisible size-sm" disabled /></td>

                        <!-- CUM PLAN -->
                        <td id="" name="" class="bg-[#D1FAE5] form-control size-sm">
                            <input type="number" min="0" ng-model="plan_item.completed_acum" class="form-control input_invisible size-sm" disabled>
                        </td>


                        <td id="" name="" class="bg-[#D1FAE5] form-control size-sm">
                            <input type="text" min="0" ng-model="plan_item.completed_percent" class="form-control input_invisible size-sm" disabled>
                        </td>


                        <!-- PLANNED INTERRUPTION -->
                        <td>
                            <select class="form-control input_invisible" ng-model="plan_item.selected_interruption" ng-change="interruption_changed(plan_item)" ng-options="interruption as interruption.interruption_name for interruption in interruptions" disabled>
                                <option value="" ng-if="false"></option>
                            </select>
                        </td>


                        <!-- NOT PLANNED INTERRUPTION -->
                        <td>
                            <select class="form-control input_invisible" ng-model="plan_item.selected_not_planned_interruption" ng-change="interruption_changed(plan_item)" ng-options="interruption as interruption.interruption_name for interruption in not_planned_interruptions" disabled>
                                <option value="" ng-if="false"></option>
                            </select>
                        </td>

                        <!--
                        <td class="bg-[#D1FAE5] form-control size-sm" id="">
                            <input class="size-sm" type="number" ng-model="plan_item.interruption_value" name="" id="" disabled="true">
                        </td>

                      
                        <td class="bg-[#D1FAE5] form-control size-sm" id="">
                            <input class="size-sm" type="number" name="" id="" ng-model="plan_item.std_time" disabled="true">
                        </td>

                      
                        <td class="bg-[#D1FAE5] form-control size-sm" id="">
                            <input class="size-sm" type="text" name="" id="" disabled="true" ng-model="plan_item.formula">
                        </td>
                        -->

                    </tr>

                    <datalist id="dl_items">
                        <option ng-repeat='item in items' value="{{item.item_number}}"></option>
                    </datalist>

                    <datalist id="dl_supervisors">
                        <option ng-repeat='supervisor in supervisors' value="{{supervisor.user_name}} {{supervisor.user_lastname}}"></option>
                    </datalist>

                </tbody>
            </table>


            <h3 class="text-center mt-3" ng-show="production_plan.plan_id == null && detail_loaded == true">There was no Plan for the date and output.</h3>

            <div class="flex justify-end mt-5">

                <button type="button" class="btn btn_secondary uppercase ltr:mr-2" ng-click="cancel()">
                    <span class="la la-arrow-left ltr:mr-2 rtl:ml-2"></span>
                    Back
                </button>
            </div>
        </div>



    </form>


    <!--
        In this section I will put 
     -->
    <div id="inputExcelDataModal" class="modal modal_aside" data-animations="fadeInRight, fadeOutRight">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Paste Excel Data in Box (Ctrl + V)</h2>
                    <button type="button" class="close la la-times" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="mt-5">
                        <textarea class="form-control" rows="20" ng-model="excel_data">
                    </textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="flex ltr:ml-auto rtl:mr-auto">
                        <button type="button" class="btn btn_secondary uppercase" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn_primary ltr:ml-2 rtl:mr-2 uppercase" data-dismiss="modal" ng-click="paste_from_input()">Copy Data </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        $scope.plants = null;
        $scope.selected_plant;

        $scope.sites = null;
        $scope.selected_site;

        $scope.assets = null;
        $scope.selected_asset;

        $scope.selected_date;

        //El plan de produccion
        $scope.production_plan = null;
        //$scope.plan_date = null;
        //La lista de items (item_number, etc..)
        $scope.items = null;
        //Lista de interrupciones
        $scope.interruptions = null;

        $scope.not_planned_interruptions = null;

        $scope.supervisors = null;

        $scope.display_loading = false;

        //api/plan/get_selection_data

        $scope.init = function() {
            //get data for download selection system...

            $http({
                method: 'get',
                url: '<?= base_url() ?>index.php/api/plan/get_selection_data',
            }).then(function successCallback(response) {
                console.log(response.data);
                $scope.plants = response.data.plants;
                $scope.sites = response.data.sites;
                $scope.assets = response.data.assets;
            });

        }

        $scope.switch_plan = function(asset_id, date) {
            $scope.asset_id = asset_id;
            $scope.date = date;
            console.log('date de hoy ' + $scope.date);
            $scope.getData();

        }

        $scope.change_date = function() {
            var changed_date = $scope.production_plan.date_display.toISOString().split('T')[0];
            $scope.switch_plan($scope.asset_id, changed_date);
        }


        $scope.detail_loaded = false;

        $scope.search = function() {
            $scope.display_loading = true;
            var changed_date = $scope.selected_date.toISOString().split('T')[0];
            $scope.switch_plan($scope.selected_asset, changed_date);
        }


        $scope.getData = function() {
            $http({
                method: 'get',
                url: '<?= base_url() ?>index.php/api/plan/get_detail_data',
                params: {
                    asset_id: $scope.asset_id,
                    date: $scope.date
                }
            }).then(function successCallback(response) {

                console.log(response.data);

                //Load items
                $scope.items = response.data.items;

                //Load interruptions
                $scope.interruptions = response.data.interruptions;

                $scope.not_planned_interruptions = response.data.not_planned_interruptions;

                $scope.supervisors = response.data.supervisors;

                //Load production_plan
                $scope.production_plan = response.data.production_plan;

                //production_plan.use_multiplier_factor
                if (response.data.production_plan.use_multiplier_factor == 0)
                    $scope.production_plan.use_multiplier_factor = false;
                else if (response.data.production_plan.use_multiplier_factor == 1)
                    $scope.production_plan.use_multiplier_factor = true;

                //$scope.plan_date = new Date(response.data.date);
                const separated_date = response.data.production_plan.date.split("-");

                console.log(separated_date);

                $scope.production_plan.date_display = new Date(parseInt(separated_date[0]), parseInt(separated_date[1] - 1), parseInt(separated_date[2]));

                for (var i = 0; i < $scope.production_plan.plan_by_hours.length; i++) {
                    var plan_item = response.data.production_plan.plan_by_hours[i];

                    //plan_item.invalid_planned_head_count = false;
                    plan_item.time_display = new Date(response.data.production_plan.plan_by_hours[i].time);
                    plan_item.time_end_display = new Date(response.data.production_plan.plan_by_hours[i].time_end);

                    //Estos numeros necesitan estar definidos como numteros
                    //console.log($scope.production_plan.plan_by_hours[i].planned_head_count);
                    if ($scope.production_plan.plan_by_hours[i].planned_head_count == null)
                        plan_item.planned_head_count = undefined;
                    else
                        plan_item.planned_head_count = Number($scope.production_plan.plan_by_hours[i].planned_head_count);

                    if ($scope.production_plan.plan_by_hours[i].planned == null) {
                        plan_item.planned = undefined;
                        plan_item.completed = undefined;
                    } else {
                        plan_item.planned = Number($scope.production_plan.plan_by_hours[i].planned);
                        plan_item.completed = Number($scope.production_plan.plan_by_hours[i].completed);
                    }





                    if ($scope.production_plan.plan_by_hours[i].std_time == null)
                        plan_item.std_time = undefined;
                    else
                        plan_item.std_time = Number($scope.production_plan.plan_by_hours[i].std_time);

                    if ($scope.production_plan.plan_by_hours[i].interruption_value == null)
                        plan_item.interruption_value = undefined;
                    else
                        plan_item.interruption_value = Number($scope.production_plan.plan_by_hours[i].interruption_value);




                    //plan_item.interruption_id = plan_item.selected_interruption.interruption_id;
                }

                $scope.updateItems();

                $scope.display_loading = false;
                $scope.detail_loaded = true;
            });
        }


        $scope.updateItems = function() {


            for (var i = 0; i < $scope.production_plan.plan_by_hours.length; i++) {

                if ($scope.production_plan.plan_by_hours[i].interruption_id == null)
                    $scope.production_plan.plan_by_hours[i].interruption_id = null;
                else
                    $scope.production_plan.plan_by_hours[i].interruption_id = Number($scope.production_plan.plan_by_hours[i].interruption_id);

                var foundInterruption = $scope.interruptions.filter(function(interr) {
                    return Number(interr.interruption_id) === $scope.production_plan.plan_by_hours[i].interruption_id;
                })[0];
                if (foundInterruption)
                    $scope.production_plan.plan_by_hours[i].selected_interruption = foundInterruption;


                var foundNotPlannedInterruption = $scope.not_planned_interruptions.filter(function(interr) {
                    return Number(interr.not_planned_interruption_id) === $scope.production_plan.plan_by_hours[i].not_planned_interruption_id;
                })[0];
                if (foundNotPlannedInterruption)
                    $scope.production_plan.plan_by_hours[i].selected_not_planned_interruption = foundNotPlannedInterruption;



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
                $scope.calculate_formula($scope.production_plan.plan_by_hours[i]);
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
            var totalCompleted = 0;
            for (let i = 0; i < count; i++) {
                //$scope.production_plan.plan_by_hours[i].planned_acum = $scope.production_plan.plan_by_hours[i].planned;

                if ($scope.production_plan.plan_by_hours[i].planned == null || $scope.production_plan.plan_by_hours[i].undefined) {
                    total += 0;
                    totalCompleted += 0;
                } else {
                    total += $scope.production_plan.plan_by_hours[i].planned;
                    $scope.production_plan.plan_by_hours[i].planned_acum = total;

                    totalCompleted += $scope.production_plan.plan_by_hours[i].completed;
                    $scope.production_plan.plan_by_hours[i].completed_acum = totalCompleted;

                    //completed_percent

                    $scope.production_plan.plan_by_hours[i].completed_percent = '' + parseInt((totalCompleted * 100) / total) + '%';

                }


            }
        }



        $scope.hc_changed = function(plan_item) {
            $scope.calculate_formula(plan_item);
        }


        $scope.interruption_changed = function(plan_item) {
            plan_item.interruption_id = plan_item.selected_interruption.interruption_id;
            plan_item.interruption_value = parseFloat(plan_item.selected_interruption.interruption_time);

            $scope.calculate_formula(plan_item);
        }


        $scope.calculate_formula = function(plan_item) {
            //console.log("calculate formula....")
            //console.log(plan_item);

            if (plan_item == undefined)
                return;

            if (plan_item.planned_head_count == undefined || plan_item.planned == undefined || plan_item.std_time == undefined) {
                plan_item.formula = undefined;
            } else {
                plan_item.formula = parseFloat((plan_item.planned_head_count - (plan_item.interruption_value == undefined ? 0 : plan_item.interruption_value)) / plan_item.std_time).toFixed(2);
            }
        }



        $scope.cancel = function() {
            window.location.replace("<?php echo base_url() ?>");
        }


        $scope.excel_data = null;


        //2022-03-29 11:05:52
        //este es al cargar

        $scope.init();

    }]);
</script>