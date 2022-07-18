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
        <li><a href="<?php echo base_url(); ?>index.php">Inicio</a></li>
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
        <div style="display:flex; justify-content: flex-end;">

            <a data-toggle="tooltip" data-tippy-content="Descarga la informacion a un excel" data-tippy-placement="right">
                <button type="button" class="btn btn-icon btn-icon_large btn_info uppercase" style="margin-right: 5px;" aria-expanded="false" ng-csv="getRowsForExcel()" csv-header="getHeadersForExcel()" field-separator="," decimal-separator="." filename="MyPlan.csv">
                    <span class="las la-download"></span>
                </button>
            </a>

            <!-- Removed ng-click="copy_clipboard()" -->
            <a data-toggle="tooltip" data-tippy-content="Pegar la informacion del excel en la tabla" data-tippy-placement="right">
                <button type="button" class="btn btn-icon btn-icon_large btn_info uppercase" data-toggle="modal" data-target="#inputExcelDataModal" aria-expanded="false">
                    <span class="las la-paste"></span>
                </button>
            </a>
        </div>
        <table class="table table_bordered w-full mt-3">
            <thead class="text-xs">
                <tr>
                    <th scope="col" class="bg-[#D1FAE5]"><small>PLANTA:</small></th>
                    <th scope="col">
                        <input type="text" name="" value="" ng-model="production_plan.plant_name" disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>AREA:</small></th>
                    <th scope="col">
                        <input type="text" name="" value="" ng-model="production_plan.site_name" disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>SALIDA:</small></th>
                    <th scope="col">
                        <input type="text" name="" value="" ng-model="production_plan.asset_name" disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>HC:</small></th>
                    <th scope="col">
                        <input type="number" min="1" name="hc" id="" onkeyup="" ng-model="production_plan.hc" ng-change="sethc()" class="form-control input_invisible size-sm" />
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>FECHA:</small></th>
                    <th scope="col">
                        <input style="min-width: 10rem; border: 0;" name="date" ng-model="production_plan.date_display" ng-change="change_date()" class="form-control size-sm" type="date">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>SUPERVISOR:</small></th>
                    <th scope="col">
                        <input placeholder="Select" type="text" ng-model="production_plan.supervisor" class="form-control size-sm" list="dl_supervisors" required />
                    </th>
                </tr>
            </thead>
        </table>
        <div style="display: flex; justify-content:flex-end;">
            <div class=" my-3 px-5 text-right mt-3">
                <input class="form-check-input mt-1" id="flexCheckDefault" ng-model="production_plan.use_multiplier_factor" type="checkbox">
                <label class="form-check-label px-3 mt-0" for="flexCheckDefault">Factor multiplicador</label>
                <input class="form-control" style="width: 12rem;" type="number" min="2" ng-model="production_plan.multiplier_factor" ng-disabled="!production_plan.use_multiplier_factor" value="1" id="">
            </div>
        </div>
        <div>
            <table class="table relative table_bordered w-full mt-3 text-center">
                <thead>
                    <tr class="bg-[#059669] sticky my-5">
                        <th scope="col" class="text-white text-xs sticky top-0">HR</th>
                        <th scope="col" class="text-white text-xs sticky top-0">HC</th>
                        <th scope="col" class="text-white text-xs sticky top-0">NUMERO DE PIEZA</th>
                        <th scope="col" class="text-white text-xs sticky top-0">NUMERO DE WO</th>
                        <th scope="col" class="text-white text-xs sticky top-0">PLAN</th>
                        <th scope="col" class="text-white text-xs sticky top-0">CUM PLAN</th>
                        <th scope="col" class="text-white text-xs sticky top-0">INTERRUPCION PLA</th>
                        <th scope="col" class="text-white text-xs sticky top-0">TIEMPO MENOS</th>
                        <th scope="col" class="text-white text-xs sticky top-0">TIEMPO ESTANDAR</th>
                        <th scope="col" class="text-white text-xs sticky top-0">
                            CALCUC CANTIDAD POR HORA <br />
                            HC x (1-MENOS TIEMPO) / (TIEMPO ESTANDAR)
                        </th>
                    </tr>
                </thead>
                <tbody class="text-center">


                    <tr ng-repeat="plan_item in production_plan.plan_by_hours">
                        <!-- 6:00-7:00am -->
                        <th style="min-width: 7rem;" class="bg-[#D1FAE5] text-xs">{{plan_item.time_display | date:'hh:mm'}}-{{plan_item.time_end_display | date:'hh:mm'}} {{ plan_item.time_display.getHours() >= 12  ? 'pm' : 'am'}}</th>

                        <!-- HC -->
                        <td id="" class="bg-[#D1FAE5] ">
                            <input type="number" min="1" type="text" name="" onkeyup="" class="form-control input_invisible size-sm" ng-model="plan_item.planned_head_count" ng-class="{red: plan_item.invalid_planned_head_count}" ng-change="hc_changed(plan_item)" />
                        </td>

                        <!-- ITEM NUMBER -->
                        <td>
                            <input placeholder="Select" style="text-transform: uppercase;" type="text" ng-model="plan_item.item" ng-class="{red: plan_item.invalid_item}" class="form-control input_invisible size-sm" list="dl_items" required />
                        </td>

                        <!-- WORKORDER  -->
                        <td><input type="text" name="" ng-model="plan_item.workorder" ng-class="{red: plan_item.invalid_workorder}" class="form-control input_invisible size-sm"></td>

                        <!-- PLAN BY HOUR -->
                        <td id=""><input type="number" min="0" onkeyup="" ng-model="plan_item.planned" ng-class="{red: plan_item.invalid_planned}" ng-change="planned_changed(plan_item)" class="form-control input_invisible size-sm" /></td>


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
                            <input class="size-sm" type="number" ng-model="plan_item.interruption_value" name="" id="" disabled="true">
                        </td>

                        <!-- STD TIME -->
                        <td id="">
                            <input class="form-control input_invisible size-sm" type="number" name="" id="" ng-model="plan_item.std_time" ng-change="stdtime_changed(plan_item)">
                        </td>

                        <!-- CALCULATED QTY BY HR -->
                        <td class="bg-[#D1FAE5] form-control size-sm" id="">
                            <input class="size-sm" type="number" name="" id="" disabled="true" ng-model="plan_item.formula">
                        </td>
                    </tr>

                    <datalist id="dl_items">
                        <option ng-repeat='item in items' value="{{item.item_number}}"></option>
                    </datalist>

                    <datalist id="dl_supervisors">
                        <option ng-repeat='supervisor in supervisors' value="{{supervisor.user_name}} {{supervisor.user_lastname}}"></option>
                    </datalist>

                </tbody>
            </table>
            <div class="flex justify-end mt-5">

                <button type="button" class="btn btn_secondary uppercase ltr:mr-2" ng-click="cancel()">
                    <span class="la la-arrow-left ltr:mr-2 rtl:ml-2"></span>
                    Cancelar
                </button>

                <button type="button" class="btn btn_success uppercase" ng-click="save()">
                    <span class="la la-save ltr:mr-2 rtl:ml-2"></span>
                    Guardar plan
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
                    <h2 class="modal-title">Pega la informacion del excel en la caja (Ctrl + V)</h2>
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
                        <button type="button" class="btn btn_secondary uppercase" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn_primary ltr:ml-2 rtl:mr-2 uppercase" data-dismiss="modal" ng-click="paste_from_input()">Copiar informacion </button>
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
    var fetch = angular.module('plannerApp', ['ngSanitize', 'ngCsv']);
    fetch.controller('planController', ['$scope', '$http', function($scope, $http) {

        //El plan de produccion
        $scope.production_plan = null;
        //$scope.plan_date = null;

        //La lista de items (item_number, etc..)
        $scope.items = null;

        //Lista de interrupciones
        $scope.interruptions = null;

        $scope.supervisors = null;

        $scope.display_loading = true;

        $scope.init = function(asset_id, date) {
            $scope.asset_id = asset_id;
            $scope.date = date;
            console.log('date de hoy ' + $scope.date);
            $scope.getData();

        }

        $scope.change_date = function() {
            var changed_date = $scope.production_plan.date_display.toISOString().split('T')[0];
            $scope.init($scope.asset_id, changed_date);
        }


        $scope.getData = function() {
            console.log('getData');

            $http({
                method: 'get',
                url: '<?= base_url() ?>index.php/api/plan/get_data',
                params: {
                    asset_id: $scope.asset_id,
                    date: $scope.date
                }
            }).then(function successCallback(response) {

                console.log(response.data);


                //Load items
                $scope.items = response.data.items;
                //console.log($scope.items);

                //Load interruptions
                $scope.interruptions = response.data.interruptions;
                //console.log($scope.interruptions);

                $scope.supervisors = response.data.supervisors;
                //console.log($scope.supervisors);

                //Load production_plan
                $scope.production_plan = response.data.production_plan;
                console.log($scope.production_plan);


                //production_plan.use_multiplier_factor
                if (response.data.production_plan.use_multiplier_factor == 0)
                    $scope.production_plan.use_multiplier_factor = false;
                else if (response.data.production_plan.use_multiplier_factor == 1)
                    $scope.production_plan.use_multiplier_factor = true;

                //$scope.plan_date = new Date(response.data.date);

                const separated_date = response.data.production_plan.date.split("-");


                $scope.production_plan.date_display = new Date(parseInt(separated_date[0]), parseInt(separated_date[1] - 1), parseInt(separated_date[2]));


                console.log($scope.production_plan.date_display);


                for (var i = 0; i < $scope.production_plan.plan_by_hours.length; i++) {

                    console.log('for entering ' + i);

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

                    if ($scope.production_plan.plan_by_hours[i].planned == null)
                        plan_item.planned = undefined;
                    else
                        plan_item.planned = Number($scope.production_plan.plan_by_hours[i].planned);

                    if ($scope.production_plan.plan_by_hours[i].std_time == null)
                        plan_item.std_time = undefined;
                    else
                        plan_item.std_time = Number($scope.production_plan.plan_by_hours[i].std_time);

                    if ($scope.production_plan.plan_by_hours[i].interruption_value == null)
                        plan_item.interruption_value = undefined;
                    else
                        plan_item.interruption_value = Number($scope.production_plan.plan_by_hours[i].interruption_value);
                    //plan_item.interruption_id = plan_item.selected_interruption.interruption_id;

                    $scope.calculate_formula(plan_item);
                }

                $scope.updateItems();



                $scope.display_loading = false;

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


            }


            $scope.update_acum();

        }




        $scope.getInterruptionFromName = function(interruption_name) {

            if (interruption_name == undefined) return null;
            console.log('getInterruptionFromName ' + interruption_name);

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


        $scope.planned_changed = function(plan_item) {
            $scope.update_acum();
        }



        $scope.update_acum = function() {
            var count = $scope.production_plan.plan_by_hours.length;
            var total = 0;
            for (let i = 0; i < count; i++) {
                //$scope.production_plan.plan_by_hours[i].planned_acum = $scope.production_plan.plan_by_hours[i].planned;

                if ($scope.production_plan.plan_by_hours[i].planned == null || $scope.production_plan.plan_by_hours[i].undefined) {
                    total += 0;
                } else {
                    total += $scope.production_plan.plan_by_hours[i].planned;
                    $scope.production_plan.plan_by_hours[i].planned_acum = total;
                }

            }
        }



        $scope.hc_changed = function(plan_item) {
            $scope.calculate_formula(plan_item);
        }

        $scope.stdtime_changed = function(plan_item) {
            $scope.calculate_formula(plan_item);
        }


        $scope.interruption_changed = function(plan_item) {
            plan_item.interruption_id = plan_item.selected_interruption.interruption_id;
            plan_item.interruption_value = parseFloat(plan_item.selected_interruption.interruption_time);

            $scope.calculate_formula(plan_item);
        }


        $scope.calculate_formula = function(plan_item) {
            console.log("calculate formula....")
            //console.log(plan_item);

            if (plan_item == undefined)
                return;

            if (plan_item.planned_head_count == undefined || plan_item.planned == undefined || plan_item.std_time == undefined) {

                //console.log("debug 01....");
                //console.log("hc" + plan_item.planned_head_count);
                //console.log("planned" + plan_item.planned);
                //console.log("std" + plan_item.std_time);
                plan_item.formula = undefined;
            } else {

                let less_time = 0;
                if (!(plan_item.interruption_value == undefined || plan_item.interruption_value == '')) {
                    less_time = plan_item.interruption_value;
                }

                //plan_item.formula = parseFloat((plan_item.planned_head_count - (plan_item.interruption_value == undefined ? 0 : plan_item.interruption_value)) / plan_item.std_time).toFixed(2);
                plan_item.formula = parseInt(plan_item.planned_head_count * ((1 - less_time) / plan_item.std_time.toFixed(2)));

                //console.log("formula es " + plan_item.formula);
                //1 x (1 - )

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

            $scope.display_loading = true;

            var has_errors = false;

            //esta variable se utiliza para validar que haya algun row para guardar de la totalidad, si no tiene datos para guardar descartar el guardado
            var has_edited_rows = false;
            var total_planned_hours = 0;

            for (let i = 0; i < $scope.production_plan.plan_by_hours.length; i++) {

                console.log('item ' + i);
                console.log($scope.production_plan.plan_by_hours[i])

                let currentItem = $scope.production_plan.plan_by_hours[i];

                if (currentItem.planned != null)
                    total_planned_hours += $scope.production_plan.plan_by_hours[i].planned;

                let has_planned = true;
                let has_item = true;
                let has_workorder = true;
                let has_planned_head_count = true;

                if (currentItem.planned == undefined || currentItem.planned == null || currentItem.planned == ''

                ) {
                    has_planned = false;
                }

                if (currentItem.item == undefined || currentItem.item == null || currentItem.item == ''

                ) {
                    has_item = false;
                }

                if (currentItem.workorder == undefined || currentItem.workorder == null || currentItem.workorder == ''

                ) {
                    has_workorder = false;
                }


                if (currentItem.planned_head_count == undefined || currentItem.planned_head_count == null || currentItem.planned_head_count == ''

                ) {
                    has_planned_head_count = false;
                }

                console.log('debug 01');
                console.log('has_planned' + has_planned);
                console.log('has_item' + has_item);
                console.log('has_workorder' + has_workorder);
                console.log('has_planned_head_count' + has_planned_head_count);

                if (has_planned || has_item || has_workorder || has_planned_head_count) {

                    console
                    //Checar que esten definidos los 4 Datos
                    if (!(has_planned && has_item && has_workorder && has_planned_head_count)) {
                        has_errors = true;
                        currentItem.invalid_planned_head_count = !has_planned_head_count;
                        currentItem.invalid_item = !has_item;
                        currentItem.invalid_workorder = !has_workorder;
                        currentItem.invalid_planned = !has_planned;
                    }
                }

                if (has_planned && has_item && has_workorder && has_planned_head_count) {
                    has_edited_rows = true;
                }

            }

            console.log("PLANNED HOURS " + total_planned_hours);
            if (total_planned_hours <= 0) {
                $scope.display_loading = false;
                swal("Something was wrong!", "You have no planned hours at all, at least one planned hour must be greated than 0 in play by hour column. ", "error");
                return;
            }

            if (has_errors) {
                $scope.display_loading = false;
                swal("Something was wrong!", "You have some data incompleted! check item number, workorder, hc and planned from all row ", "error");
                return;
            }

            if (!has_edited_rows) {
                $scope.display_loading = false;
                swal("Something was wrong!", "You have no data to save! you need to fill at least one row.", "error");
                return;
            }


            if ($scope.production_plan.use_multiplier_factor) {
                var validated = true;
                if (isNaN($scope.production_plan.multiplier_factor)) {
                    validated = false;
                } else {

                    if (!Number.isInteger($scope.production_plan.multiplier_factor)) {
                        //Si no es entero
                        validated = false;
                    } else {
                        //Si es entero validar que sea mayor que uno
                        if (Number($scope.production_plan.multiplier_factor) < 2) {
                            validated = fase;
                        }
                    }
                }
                if (!validated) {
                    $scope.display_loading = false;
                    swal("Something was wrong!", "The multiplier factor must be a number greater than one.", "error");
                    return;
                }
            }

            if ($scope.production_plan.supervisor == null || $scope.production_plan.supervisor == undefined || $scope.production_plan.supervisor == '') {
                $scope.display_loading = false;
                swal("Something was wrong!", "Please fill the supervisor field.", "error");
                return;
            }


            for (let i = 0; i < $scope.production_plan.plan_by_hours.length; i++) {
                let currentItem = $scope.production_plan.plan_by_hours[i];
                currentItem.invalid_planned_head_count = false;
                currentItem.invalid_item = false;
                currentItem.invalid_workorder = false;
                currentItem.invalid_planned = false;
            }

            console.log($scope.production_plan);

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
                $scope.display_loading = false;
                console.log(response.data);
                swal("Your plan modifications have been saved. You'll be redirected.")
                    .then((value) => {
                        window.location.replace("<?php echo base_url() ?>measuring_point?site_id=" + $scope.production_plan.site_id + "&plant_id=" + $scope.production_plan.plant_id);
                    });

            }, function(response) {
                $scope.display_loading = false;
                // this function handles error
            });


        }

        $scope.cancel = function() {
            window.location.replace("<?php echo base_url() ?>measuring_point?site_id=" + $scope.production_plan.site_id + "&plant_id=" + $scope.production_plan.plant_id);
        }


        $scope.excel_data = null;

        $scope.paste_from_input = function() {
            console.log($scope.excel_data);
            if ($scope.excel_data == null) return;

            const column_hc = 1;
            const column_item = 2;
            const column_workorder = 3;
            const plan_by_hour = 4;
            const planned_interuption = 5;
            var lines = $scope.excel_data.trim().split("\n");

            //deleted box...
            $scope.excel_data = null;

            let table_row = 0;
            for (let i = 1; i < lines.length; i++) {
                //console.log('goes beyond all lines');

                var line = lines[i];
                if (line == '' || line == undefined) {
                    //console.log('arrived here');
                    break;
                }

                console.log('line is ' + line);

                var rows = line.split("\t");

                if (rows.length < 5) {
                    rows = rows.concat(['', '', '', '', '', ]);
                }

                console.log('+++++++' + rows);

                if (rows[column_hc] == '')
                    $scope.production_plan.plan_by_hours[table_row].planned_head_count = undefined;
                else
                    $scope.production_plan.plan_by_hours[table_row].planned_head_count = Number(rows[column_hc]);

                $scope.production_plan.plan_by_hours[table_row].item = rows[column_item];


                $scope.production_plan.plan_by_hours[table_row].workorder = rows[column_workorder];

                if (rows[plan_by_hour] == '')
                    $scope.production_plan.plan_by_hours[table_row].planned = undefined;
                else
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
        }


        $scope.copy_clipboard = function() {
            //console.log('entering to copy clipboard');
            const column_hc = 1;
            const column_item = 2;
            const column_workorder = 3;
            const plan_by_hour = 4;
            const planned_interuption = 5;

            (async () => {
                var text = await navigator.clipboard.readText();
                //console.log(text);

                var lines = text.split("\n");

                let table_row = 0;

                for (let i = 1; i < lines.length; i++) {
                    console.log('doing in line' + i);

                    var line = lines[i];
                    if (line == '') {
                        //console.log('arrived here');
                        break;
                    }

                    var rows = line.split("\t");

                    //console.log(rows);
                    $scope.production_plan.plan_by_hours[table_row].planned_head_count = Number(rows[column_hc]);

                    $scope.production_plan.plan_by_hours[table_row].item = rows[column_item];


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
        //2022-03-29 11:05:52
        //este es al cargar

        $scope.download_excel_data = function() {

        }


        $scope.getHeadersForExcel = function() {
            return ["HR", "HC", "ITEM NUMBER", "WORKORDER", "PLANNED", "INTERRUPTION"];
        }


        $scope.getHour = function(dateTime, use_ampm) {
            console.log(dateTime);

            var hours = dateTime.getHours() % 12 || 12;

            var str = hours + ':00';

            if (use_ampm) {
                if (dateTime.getHours() >= 12)
                    str += ' pm';
                else
                    str += ' am';
            }


            return str;
        }


        $scope.getRowsForExcel = function() {

            // plan_item in production_plan.plan_by_hours
            const items = [];

            $scope.production_plan.plan_by_hours.forEach(element => {

                console.log(element);

                let time = $scope.getHour(element.time_display, false) + '-' + $scope.getHour(element.time_end_display, true);

                let interruption_name = (element.selected_interruption == null) ? '' : element.selected_interruption.interruption_name;

                const item = [time, element.planned_head_count, element.item, element.workorder, element.planned, interruption_name];
                items.push(item);
            });

            return items;
        }


        $scope.init(<?php echo $asset_id . ", '" . $date . "'" ?>);
    }]);
</script>