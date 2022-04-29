 <style>
     .card:hover {
         background-color: #BFE2F3;
     }
 </style>

 <!-- Brand -->
 <span class="brand" style="margin-top: -6.5rem;">
     <img width="150" src="<?php echo base_url(); ?>assets/images/transparente.png" alt="">
 </span>
 <!-- Breadcrumb -->
 <section class="breadcrumb" ng-app="appMonitor" ng-controller="CtrlMonitor">
     <h1><?= $title ?></h1>

     <!--
     <ul>
         <li class="divider la la-arrow-right"></li>
         <li>{{ plant_name }}</li>
         <li class="divider la la-arrow-right"></li>
         <li>{{ site_name }}</li>
     </ul>
    -->

     <div class="grid lg:grid-cols-2 gap-5 p-5">

         <div class="card p-5">
             <h3>1. Select Plant</h3>
             <form class="mt-2">
                 <div class="custom-select">
                     <select class="form-control" ng-options="plant.plant_name for plant in plants" ng-model="selected_plant"> </select>
                     <div class="custom-select-icon la la-caret-down"></div>
                 </div>
             </form>
         </div>


         <div class="card p-5">
             <h3>2. Select Site</h3>
             <form class="mt-2">
                 <div class="custom-select">
                     <select class="form-control" ng-options="site.site_name for site in sites  |  filter : {'plant_id': selected_plant.plant_id } " ng-model="selected_site" ng-change="site_changed()"> </select>
                     <div class="custom-select-icon la la-caret-down"></div>
                 </div>
             </form>
         </div>
     </div>

     <div class="grid lg:grid-cols-1 gap-5 p-2">
         <h3 class="text-center">3. Select Monitor</h3>
     </div>

     <h4 class="text-center" ng-show="monitors.length == 0">There are no monitors on this site / not selected site</h4>

     <div class="grid lg:grid-cols-4 gap-5 p-5">

         <div class="card p-5" ng-repeat="monitor in monitors" ng-click="selectMonitor(monitor)">

             <div class="items-center px-5 py-2">
                 <h5 class="mb-0 uppercase"> {{ monitor.monitor_name }} </h5>
                 <!--<small>Selet a cell</small>-->
             </div>

             <hr>

             <p ng-show="monitor.assets.length == 0" style="color:red"> No assets </p>

             <table class="table table_list mt-3 w-full">
                 <thead>
                     <tr ng-repeat="item in monitor.assets">
                         <th>
                             {{ item.asset_name }}
                         </th>
                     </tr>
                 </thead>
             </table>



         </div>


     </div>
 </section>


 <script>
     var app = angular.module('appMonitor', []);
     app.controller('CtrlMonitor', function($scope, $http) {

         $scope.plants = [];
         $scope.selected_plant = null;

         $scope.sites = [];
         $scope.selected_site = null;

         $scope.site_id = null;
         $scope.monitors = [];

         $scope.init = function() {
             $scope.getData();
         }

         $scope.getData = function() {

             $http({
                 method: 'get',
                 url: '<?= base_url() ?>index.php/output_vs_plan/get_data_plants_sites'
             }).then(function successCallback(response) {
                 $scope.plants = response.data.plants;
                 $scope.selected_plant = $scope.plants[0];

                 $scope.sites = response.data.sites;
                 console.log(response.data);
             });
         }

         $scope.site_changed = function() {
             console.log('site_changed');
             //retrieve data of monitors

             $http({
                 method: 'get',
                 url: '<?= base_url() ?>index.php/output_vs_plan/get_data_monitor?site_id=' + $scope.selected_site.site_id
             }).then(function successCallback(response) {

                 $scope.monitors = response.data.monitors;
                 console.log(response.data);
             });
         }

         $scope.selectMonitor = function(monitor) {
             //console.log('select monitor' + monitor_id);
             //output_vs_plan
             //console.log('assets' + monitor.assets.length);

             if (monitor.assets.length != 0)
                 window.location.href = "<?php echo base_url(); ?>output_vs_plan?monitor_id=" + monitor.monitor_id;
         }


         $scope.init();

     });
 </script>