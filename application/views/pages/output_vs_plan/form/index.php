<div class="grid lg:grid-cols-1 gap-5" ng-app="monitorsApp" ng-controller="monitorsController">

    <div class="grid sm:grid-cols-3 gap-5 my-5">

        <!--
        <div class="card p-5">
            <form class="relative mt-5">
                <label class="label absolute block bg-input top-0 ltr:ml-3 rtl:mr-3 px-1 rounded font-heading uppercase" for="input-1">Plant</label>
                <input id="input-1" type="text" class="form-control mt-2 pt-5" placeholder="Select Plant">

            </form>
        </div>

        <div class="card p-5">
            <form class="relative mt-5">
                <label class="label absolute block bg-input top-0 ltr:ml-3 rtl:mr-3 px-1 rounded font-heading uppercase" for="input-1">Site</label>
                <input id="input-1" type="text" class="form-control mt-2 pt-5" placeholder="Select Site">

            </form>
        </div>
-->

        <div class="card p-5">
            <form class="relative mt-5">
                <label class="label absolute block bg-input top-0 ltr:ml-3 rtl:mr-3 px-1 rounded font-heading uppercase" for="input-1">Screen name</label>
                <input id="input-1" type="text" class="form-control mt-2 pt-5" placeholder="Enter screen name here" ng-model="screen_name">
                <div style="margin-top:1rem; display:flex; justify-content:flex-end;">
                    <button class="btn btn_success uppercase" ng-disabled="screen_name == ''" ng-click="add_screen()">Add Screen</button>
                </div>
            </form>
        </div>
    </div>
    <div class="grid sm:grid-cols-3 gap-5 my-5">


        <div class="card p-5" ng-repeat="monitor in monitors">
            <span class="icon las la-trash" style="display: flex; justify-content:flex-end; font-size:2rem" ng-click="remove_screen(monitor)"></span>
            <h3 class="uppercase text-center">{{ monitor.monitor_name }}</h3>
            <form class="relative mt-5">
                <div class="input-group mt-5">

                    <select class="form-control input-group-item" ng-options="asset.asset_name for asset in assets" ng-model="monitor.selected_asset"> </select>
                    <button class="btn btn_primary uppercase input-group-item" ng-disabled="!monitor.selected_asset" ng-click="add_asset(monitor)"><span class="icon las la-plus text-danger"></span></button>
                </div>
            </form>
            <div class="mt-4">
                <table>
                    <table class="table w-full mt-3 text-center">
                        <thead>

                            <tr ng-repeat="asset in monitor.assets">
                                <th class="text-center uppercase">
                                    <h5 style="color: black;">{{asset.asset_name}}</h5>
                                </th>
                                <th class="text-center uppercase"></th>
                                <th class="text-center uppercase">
                                    <button type="button" class="btn btn-icon btn-icon_large btn_danger uppercase" ng-click="remove_asset(monitor, asset)">
                                        <span class="icon las la-trash"></span>
                                    </button>
                                </th>
                            </tr>

                        </thead>
                        <tbody>
                    </table>
            </div>
        </div>


    </div>
</div>



<script>
    var fetch = angular.module('monitorsApp', []);
    fetch.controller('monitorsController', ['$scope', '$http', '$httpParamSerializerJQLike', function($scope, $http, $httpParamSerializerJQLike) {



        //field for add screen.
        $scope.screen_name = '';

        $scope.plant_id = null;
        $scope.site_id = null;


        $scope.monitors = [];
        $scope.assets = [];

        $scope.init = function(plant_id, site_id) {
            $scope.plant_id = plant_id;
            $scope.site_id = site_id;

            $scope.getData();
        }

        $scope.getData = function() {
            $http({
                method: 'get',
                url: '<?= base_url() ?>index.php/monitors',
                params: {
                    site_id: $scope.site_id
                }
            }).then(function successCallback(response) {

                console.log(response.data);
                $scope.monitors = response.data.monitors;
                $scope.assets = response.data.assets;

            });
        }

        $scope.add_screen = function() {
            console.log('add screen');
            //need to send //monitor_name, site_id


            var data = {
                monitor_name: $scope.screen_name,
                site_id: $scope.site_id
            };
            $http({
                url: '<?= base_url() ?>monitors/monitor/insert',
                method: 'POST',
                data: $httpParamSerializerJQLike(data), // Make sure to inject the service you choose to the controller
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' // Note the appropriate header
                }
            }).then(function(response) {
                console.log(response.data.data);
                $scope.monitors.push(response.data.data);
                $scope.screen_name = '';
            }).catch((error) => {
                console.log(error);
            });
        }


        $scope.remove_screen = function(monitor) {
            console.log('remove screen');
            //need to send //monitor_name, site_id

            var data = {
                monitor_id: monitor.monitor_id
            };
            $http({
                url: '<?= base_url() ?>monitors/monitor/delete',
                method: 'POST',
                data: $httpParamSerializerJQLike(data), // Make sure to inject the service you choose to the controller
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' // Note the appropriate header
                }
            }).then(function(response) {
                console.log(response.data.data);

                var indexToDelete = $scope.monitors.indexOf(monitor);
                $scope.monitors.splice(indexToDelete, 1);

            }).catch((error) => {
                console.log(error);
            });
        }

        $scope.add_asset = function(monitor) {
            console.log(monitor);
            /*$monitor_id = $this->input->post('monitor_id');
        $asset_id = $this->input->post('asset_id');*/


            var data = {
                monitor_id: monitor.monitor_id,
                asset_id: monitor.selected_asset.asset_id,
                asset_name: monitor.selected_asset.asset_name
            };
            $http({
                url: '<?= base_url() ?>monitors/asset/insert',
                method: 'POST',
                data: $httpParamSerializerJQLike(data), // Make sure to inject the service you choose to the controller
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' // Note the appropriate header
                }
            }).then(function(response) {
                console.log(response.data.data);

                if (response.data.response == 'fail') {
                    swal("Something was wrong!", "The asset is already included.", "error");
                } else {
                    monitor.assets.push(response.data.data);
                    monitor.selected_asset = null;
                }

            }).catch((error) => {
                console.log(error);
            });

        }


        $scope.remove_asset = function(monitor, asset) {
            console.log(asset.monitor_asset_id);

            var data = {
                monitor_asset_id: asset.monitor_asset_id
            };
            $http({
                url: '<?= base_url() ?>monitors/asset/delete',
                method: 'POST',
                data: $httpParamSerializerJQLike(data), // Make sure to inject the service you choose to the controller
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' // Note the appropriate header
                }
            }).then(function(response) {
                console.log(response.data);
                //var indexToDelete = $scope.monitors.indexOf(monitor);
                //$scope.monitors.splice(indexToDelete, 1);

                var indexToDelete = monitor.assets.indexOf(asset);
                monitor.assets.splice(indexToDelete, 1);






            }).catch((error) => {
                console.log(error);
            });
        }



        $scope.init(<?php echo $plant_id ?>, <?php echo $site_id ?>);

    }]);
</script>