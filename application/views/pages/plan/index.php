<style>
    .input_invisible {
        background-color: transparent !important;
    }

    .text-white {
        color: white !important;
    }

    .size-sm {
        width: 5rem !important;
    }

    input,
    select {
        background-color: transparent;
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
                        <input type="text" name="" value="" disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>AREA:</small></th>
                    <th scope="col">
                        <input type="text" name="" value="" disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>OUTPUT:</small></th>
                    <th scope="col">
                        <input type="text" name="" value="" disabled class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>SHIFT:</small></th>
                    <th scope="col">
                        <input type="text" name="shift_id" ng-model="shift_id" 
                        data-toggle="popover"
                            data-popover-title="Shift Info"
                            data-popover-content="{{shift_name}}"
                            data-tippy-placement="right"
                        class="form-control input_invisible size-sm">
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>HC:</small></th>
                    <th scope="col">
                        <input type="number" name="" id="" onkeyup="" class="form-control input_invisible size-sm" />
                    </th>
                    <th scope="col" class="bg-[#D1FAE5]"><small>DATE:</small></th>
                    <th scope="col">
                        <input style="min-width: 10rem; border: 0;" name="date_id" class="form-control input_invisible size-sm" type="date" value="">
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
                <tbody>
                    <tr>
                        <th style="min-width: 7rem;" class="bg-[#D1FAE5] text-xs">6:00-7:00am</th>
                        <td id="" class="bg-[#D1FAE5]">
                            <input type="number" name="" id="" onkeyup="" class="form-control input_invisible size-sm" />
                        </td>
                        <td>
                            <select placeholder="Select" onkeyup="" onchange="" class="form-control input_invisible size-sm" required>
                                <option value="name">Select</option>
                            </select>
                        </td>
                        <td><input type="text" name="" value="" class="form-control input_invisible size-sm"></td>
                        <td id=""><input type="text" onkeyup="" name="" class="form-control input_invisible size-sm" /></td>
                        <td id="" name="" class="bg-[#D1FAE5] form-control size-sm">0</td>
                        <td>
                            <select placeholder="Select" onkeyup="" onchange="" class="form-control input_invisible size-sm" required>
                                <option value="name">Select</option>
                            </select>
                        </td>
                        <td class="bg-[#D1FAE5] form-control size-sm" id=""><input class="size-sm" type="text" name="" id="" disabled="true"></td>
                        <td class="bg-[#D1FAE5] form-control size-sm" id=""><input class="size-sm" type="text" name="" id="" disabled="true"></td>
                        <td class="bg-[#D1FAE5] form-control size-sm" id=""><input class="size-sm" type="text" name="" id="" disabled="true"></td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-end mt-5">
                <button type="button" class="btn btn_success uppercase" data-toggle="modal" data-target="#dialog_success">
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

   $scope.plan_id = null;
   $scope.asset_id = null;
   $scope.date = null;
   
   $scope.shift_id = null;
   $scope.shift_name = null;

   $scope.supervisor_id = null;
   $scope.supervisor = null;

   
  $scope.init = function(asset_id, shift_id, date)
  {
    $scope.shift_id = shift_id;
    $scope.asset_id = asset_id;
    $scope.date = date;

    console.log('date ' + $scope.date);

    $scope.getPlan();
  } 

  $scope.getPlan = function(){
   $http({
    method: 'get',
    url: '<?= base_url() ?>index.php/api/plan/get',
    params: {asset_id: $scope.asset_id, shift_id: $scope.shift_id, date: $scope.date}
   }).then(function successCallback(response) {

       $scope.plan_id = response.data.plan_id;

       $scope.shift_id = response.data.shift_id;
       $scope.shift_name = response.data.shift_name;

       $scope.name = response.data.name;
       
       $scope.asset_id = response.data.asset_id;
       $scope.date = response.data.date;
       $scope.supervisor_id = response.data.supervisor_id;
       
       console.log(response);   
      // Assign response to users object
       //console.log($scope.plants);
   }); 
  }


   //este es al cargar
  $scope.init(<?php echo $asset_id . ", " . $shift_id . ", '" . $date . "'" ?>);
}]);

</script>