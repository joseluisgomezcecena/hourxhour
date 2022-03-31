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
        <li><a href="#">Pages</a></li>
        <li class="divider la la-arrow-right"></li>
        <li><?= $title ?></li>
    </ul>
    <form method="POST" enctype="multipart/form-data">
        <table class="table table_bordered w-full mt-3">
            <thead class="text-xs">
                <tr>
             
                    <th scope="col" class="bg-[#D1FAE5]"><small>PLANT:</small></th>
                    <th scope="col">
                        <input type="text" name="" value="" ng-model="production_plan.plant_name" disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>AREA:</small></th>
                    <th scope="col">
                        <input type="text" name="" value="" ng-model="production_plan.site_name"  disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>OUTPUT:</small></th>
                    <th scope="col">
                        <input type="text" name="" value="" ng-model="production_plan.asset_name" disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>SHIFT:</small></th>
                    <th scope="col">
                        <input type="text" name="shift_id" ng-model="production_plan.shift_id"  class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>HC:</small></th>
                    <th scope="col">
                        <input type="number" min="1" name="hc" id="" onkeyup=""  ng-model="production_plan.hc" ng-change="sethc()" class="form-control input_invisible size-sm" />
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>DATE:</small></th>
                    <th scope="col">
                        <input style="min-width: 10rem; border: 0;" name="date" ng-model="production_plan.date_display" class="form-control input_invisible size-sm" type="date" >
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>SUPERVISOR:</small></th>
                    <th scope="col">
                        <input type="text" name="supervisor_id" value="" class="form-control input_invisible size-sm">
                    </th>
                </tr>
            </thead>
        </table>
        <div class="form-check mt-3 mb-3 d-flex justify-content-end px-5">
            <input class="form-check-input mt-2" style="width: 1.5rem; height: 1.5rem;" id="flexCheckDefault" onchange="document.getElementById('factor_multiplicador').disabled = !this.checked;" type="checkbox" value="">
            <label class="form-check-label px-3 mt-2" for="flexCheckDefault">Factor multiplicador</label>
            <input class="form-control" style="width: 12rem;" type="text" name="" disabled id="" placeholder="Factor multiplicador">
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
                            <input placeholder="Select" type="text" ng-model="plan_item.item_number" ng-change="partnumber_changed(plan_item)"  class="form-control input_invisible size-sm" list="dl_items" required/>
                        </td>
                        
                        <!-- WORKORDER  -->
                        <td><input type="text" name="" ng-model="plan_item.workorder" class="form-control input_invisible size-sm"></td>

                        <!-- PLAN BY HOUR -->
                        <td id=""><input type="number" min="0" onkeyup=""  ng-model="plan_item.planned" ng-change="planned_changed(plan_item)" class="form-control input_invisible size-sm" /></td>


                        <!-- CUM PLAN -->
                        <td id="" name="" class="bg-[#D1FAE5] form-control size-sm"   >
                            <input type="number" min="0" ng-model="plan_item.planned_acum" class="form-control input_invisible size-sm" disabled>
                        </td>

                        <!-- PLANNED INTERRUPTION -->
                        <td>
                            <select ng-model="plan_item.selected_interruption" ng-change="interruption_changed(plan_item)"  ng-options="interruption as interruption.interruption_name for interruption in interruptions"></select>
                        </td>

                           <!-- LESS TIME -->
                        <td class="bg-[#D1FAE5] form-control size-sm" id="">
                            <input class="size-sm" type="number" ng-model="plan_item.less_time" name="" id="" disabled="true">
                        </td>
                        
                           <!-- STD TIME -->
                        <td class="bg-[#D1FAE5] form-control size-sm"  id="">
                            <input class="size-sm" type="number" name="" id="" ng-model="plan_item.std_time" disabled="true">
                        </td>
                        
                           <!-- CALCULATED QTY BY HR -->
                        <td class="bg-[#D1FAE5] form-control size-sm" id="">
                            <input class="size-sm" type="text" name="" id="" disabled="true" ng-model="plan_item.formula" >
                        </td>
                    </tr>

                    <datalist id="dl_items">
                        <option  ng-repeat='item in items' value="{{item.item_number}}"></option>
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
var fetch = angular.module('plannerApp', []);
fetch.controller('planController', ['$scope', '$http', function ($scope, $http) {

    //El plan de produccion
   $scope.production_plan = null;
   
   //La lista de items (item_number, etc..)
   $scope.items = null;

   //Lista de interrupciones
   $scope.interruptions = null;
   
  $scope.init = function(asset_id, shift_id, date)
  {
    $scope.shift_id = shift_id;
    $scope.asset_id = asset_id;
    $scope.date = date;
  
    $scope.getInterruptions();
    $scope.getPlan();
    $scope.getItems();
    
    
  } 

  $scope.getPlan = function(){
   $http({
    method: 'get',
    url: '<?= base_url() ?>index.php/api/plan/get',
    params: {asset_id: $scope.asset_id, shift_id: $scope.shift_id, date: $scope.date}
   }).then(function successCallback(response) {

        console.log(response.data) ;
    
       $scope.production_plan = response.data;
       $scope.production_plan.date_display = new Date(response.data.date);

       for(var i = 0; i < $scope.production_plan.plan_by_hours.length ;i++)
       {    
  
            $scope.production_plan.plan_by_hours[i].time_display = new Date(response.data.plan_by_hours[i].time);
            $scope.production_plan.plan_by_hours[i].time_end_display = new Date(response.data.plan_by_hours[i].time_end);
            
            $scope.production_plan.plan_by_hours[i].planned_head_count =  Number($scope.production_plan.plan_by_hours[i].planned_head_count);
            $scope.production_plan.plan_by_hours[i].planned =  Number($scope.production_plan.plan_by_hours[i].planned);
            
            $scope.production_plan.plan_by_hours[i].std_time =  Number($scope.production_plan.plan_by_hours[i].std_time); 

       }
       
      
       

   }); 
  }

  $scope.getItems = function()
  {
    $http({
    method: 'get',
    url: '<?= base_url() ?>index.php/api/items/get',
   }).then(function successCallback(response) {
       console.log(response.data);
       $scope.items = response.data.items;    
       $scope.updateItems();
   }); 
  }


  $scope.updateItems = function()
  {

    for(var i = 0; i < $scope.production_plan.plan_by_hours.length ;i++)
    {
        //$scope.production_plan.plan_by_hours[i].planned_head_count = $scope.production_plan.hc;
        if ($scope.production_plan.plan_by_hours[i].item_id != undefined)
        {
            var found = $scope.items.filter(function(item) {
                return item.item_id === $scope.production_plan.plan_by_hours[i].item_id;
            })[0];

            if(found)
            {
                $scope.production_plan.plan_by_hours[i].item_number = found.item_number;
                $scope.calculate_formula($scope.production_plan.plan_by_hours[i]);
            }
        }
    }

    $scope.update_acum();

  }

  
  $scope.getInterruptions = function()
  {
    $http({
    method: 'get',
    url: '<?= base_url() ?>index.php/api/interruptions/get',
   }).then(function successCallback(response) {
       $scope.interruptions = response.data.interruptions;
        console.log($scope.interruptions );  
   }); 
  }


  $scope.sethc = function()
  {
    console.log('hc: ' +  $scope.production_plan.hc)
    for(var i = 0; i < $scope.production_plan.plan_by_hours.length ;i++)
    {
        $scope.production_plan.plan_by_hours[i].planned_head_count = $scope.production_plan.hc;
    }
  }

  $scope.partnumber_changed = function(plan_item) 
  {
    var found = $scope.items.filter(function(item) {
        return item.item_number === plan_item.item_number;
    })[0];

    if(found) {    
        plan_item.item_id = found.item_id;
        plan_item.std_time = parseFloat(found.item_run_labor);
        $scope.calculate_formula(plan_item);
    }  
  }


  $scope.planned_changed = function(plan_item) 
  {
    $scope.calculate_formula(plan_item);
    $scope.update_acum();
  }

  $scope.update_acum = function(){
    var count = $scope.production_plan.plan_by_hours.length;
    var total = 0;
    for (let i = 0; i < count; i++) {
        //$scope.production_plan.plan_by_hours[i].planned_acum = $scope.production_plan.plan_by_hours[i].planned;
        total +=  $scope.production_plan.plan_by_hours[i].planned;
        $scope.production_plan.plan_by_hours[i].planned_acum = total;
    }
  }

  $scope.hc_changed = function(plan_item) 
  {
    $scope.calculate_formula(plan_item);
  }


  $scope.interruption_changed = function(plan_item) 
  {
    plan_item.interruption_id = plan_item.selected_interruption.interruption_id;
    plan_item.less_time = parseFloat(plan_item.selected_interruption.interruption_time);
  }


  $scope.calculate_formula = function(plan_item)
  { 
    console.log("calculate formula....")
    console.log(plan_item);

    if(plan_item.planned == undefined||plan_item.std_time == undefined)
    {
        plan_item.formula = undefined;
    }
     else
    {
        plan_item.formula = parseFloat((plan_item.planned_head_count - (plan_item.less_time == undefined ? 0 : plan_item.less_time) ) / plan_item.std_time).toFixed(2);
    }
  }


  $scope.save = function()
  {
    var url = '<?= base_url() ?>index.php/api/plan/save'; 
    var data = {plan: $scope.production_plan}
    var config= {headers: {'Content-Type': 'application/json'} }
    $http.post(url, data, config).then(function (response) {
        
        console.log(response);
        
    }, function (response) {

    // this function handles error
    });
  }

   //este es al cargar
  $scope.init(<?php echo $asset_id . ", " . $shift_id . ", '" . $date . "'" ?>);
}]);

</script>