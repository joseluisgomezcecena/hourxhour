<style>
    input {
        border: transparent;
        background-color: transparent;
    }

    th {
        color: black;
        font-weight: 100 !important;
    }

    .table-disabled {
        background-color: #c2c3c4 !important;
    }

    .table-color {
        background-color: #4B5563 !important;
        color: white;
    }

    .table-green {
        background-color: #b8efc1 !important;
    }

    .text-bold {
        font-weight: bold !important;
    }
</style>
<div class="flex justify-between mb-5" style="margin-top: -6rem;">
    <span class="brand">
        <img width="150" src="<?php echo base_url(); ?>assets/images/transparente.png" alt="">
    </span>
</div>
<br>
<div class="card w-50 text-center" ng-controller="buttonController" ng-app="buttonApp">
    <div class="container mt-5">

        <?php
        if ($plan_id == null) {
            show_alert_noplan(null);
            return;
        }
        ?>

        <div class="alert alert_danger my-5" ng-hide="verified">
            <strong class="uppercase"><bdi>There is no item number.<br /></bdi></strong>
            contact your supervisor
        </div>



        <div class="mt-5">
            <table class="table w-full">
                <tr>
                    <th class="text-center uppercase table-green text-bold">Plant</th>
                    <th class="text-center uppercase table-green"><?= $plant_name ?></th>
                    <th class="text-center uppercase table-green text-bold">Area</th>
                    <th class="text-center uppercase table-green"><?= $site_name ?></th>
                    <th class="text-center uppercase table-green text-bold">Output</th>
                    <th class="text-center uppercase table-green"><?= $asset_name ?></th>

                </tr>
                </thead>
            </table>
            <table class="table w-full mb-5">
                <thead>
                    <tr>
                        <th class="text-center uppercase table-color text-bold">Last Hour</th>
                        <th class="text-center uppercase table-color text-bold">HC</th>
                        <th class="text-center uppercase table-color text-bold">Item number</th>
                        <th class="text-center uppercase table-color text-bold">WO number</th>
                        <th class="text-center uppercase table-color text-bold">Output QTY</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">

                        <?php
                        if ($last_time == null)
                            echo '<td class="table-disabled">' . $last_time_end . '</td>';
                        else
                            echo '<td class="table-disabled">' . $last_time . ' - ' . $last_time_end . '</td>';
                        ?>


                        <td class="table-disabled"><?= $last_hc ?></td>
                        <td class="table-disabled"><?= $last_item ?></td>
                        <td class="table-disabled"><?= $last_workorder ?></td>
                        <td class="table-disabled"><?= $last_completed ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div ng-show="verified">
            <h6>WO Number:</h6>
            <p><?= $workorder ?></p>
            <h5 class="mt-4">Item number:</h5>
            <h1 class="text-primary <?php if (!isset($multiplier_factor)) {
                                        echo 'mb-8';
                                    } ?> "><b><?= $item ?></b></h1>

            <?php
            if (isset($multiplier_factor)) {
                echo ' <h5 class="mb-8" style="color:red;">Multiplier factor is Activated with ' . $multiplier_factor . '</h5>';
            }
            ?>


            <div class="alert alert_success my-5" ng-if="!IsDisabledButtonModify">
                <strong class="uppercase"><bdi>Add new capture in the green field!<br /></bdi></strong>
                Don't forget to save the new capture added.
            </div>

            <div class="mt-5 mb-5">


                <input ng-model="completed" type="text" ng-style="!IsDisabledButtonModify && {'background-color':'#b8d5cd'}" class="form-control h3" ng-disabled="IsDisabledButtonModify" style="width: 5rem; text-align: center !important;"> /
                <span class="h3" style="width: 5rem; margin-left: 1rem !important;"><?= $planned ?></span>

            </div>
            <div>
                <button class="btn btn_warning" style="width: 15em; margin:auto; display:block;" ng-click="capture()" ng-disabled="!IsDisabledButtonModify">Capture</button>
            </div>
            <h6 class="mt-5">Current Hour</h6>
            <p><?= $time, '-', $time_end ?></p>
            <div class="flex  justify-end mt-8 mb-8">
                <div>
                    <label class="switch">
                        <input type="checkbox" ng-model="isModify" ng-change="EnableDisableButtonModify()">
                        <span></span>
                        <span>Modify capture</span>
                    </label>
                    <button ng-hide="IsDisabledButtonModify" ng-click="modify_item()" class="btn btn_success mt-4">Save new capture</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var fetch = angular.module('buttonApp', []);
    fetch.controller('buttonController', ['$scope', '$http', '$httpParamSerializerJQLike', '$interval', '$timeout', function($scope, $http, $httpParamSerializerJQLike, $interval, $timeout) {

        //actualizar cada hora...
        $scope.divisor_hour = 1000 * 60 * 60;
        $scope.time_in_hours = parseInt(Date.now() / $scope.divisor_hour);

        $scope.updateTime = function() {
            //console.log('update each second');
            var current = parseInt(Date.now() / $scope.divisor_hour);

            if (current != $scope.time_in_hours) {
                location.reload();
                $scope.time_in_hours = current;
            }
            //minutes
        };

        //Actualizar cada 5 minutos...
        var theInterval = $interval(function() {
            $scope.updateTime();
        }.bind(this), 1000);

        $scope.$on('$destroy', function() {
            $interval.cancel(theInterval)
        });




        $scope.IsDisabledButtonModify = true;
        $scope.verified = true;
        $scope.completed = <?= $completed ?>;

        $scope.isVerify = function() {
            var item = '<?= $item ?>';

            if (item == '') {
                $scope.verified = false;
            } else {
                $scope.verified = true;
            }
        };

        $scope.EnableDisableButtonModify = function() {
            $scope.IsDisabledButtonModify = !$scope.isModify;
        };

        $scope.capture = function() {
            var url = '<?= base_url() ?>api/manual_capture/save';
            var params = {
                plan_by_hour_id: <?= $plan_by_hour_id ?>,
                reset: 0,
                capture_type: <?= CAPTURE_BUTTON ?>
            }
            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }
            $http({
                url: url,
                method: "POST",
                params: params
            }).then(function(response) {
                $scope.completed = response.data.completed;
                $scope.IsDisabledButtonModify = true;

            }, function(response) {
                swal("Something was wrong!", '', "error");
            });
        };

        $scope.modify_item = function() {
            var data = {
                value: $scope.completed,
                plan_by_hour_id: <?= $plan_by_hour_id ?>,
                reset: 1,
                capture_type: <?= CAPTURE_BUTTON ?>
            };
            $http({
                url: '<?= base_url() ?>api/manual_capture/modify',
                method: 'POST',
                data: $httpParamSerializerJQLike(data), // Make sure to inject the service you choose to the controller
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' // Note the appropriate header
                }
            }).then(function(response) {
                if ($scope.isModify == true)
                    $scope.isModify = false;
                $scope.IsDisabledButtonModify = true;
                /* do something here */
            }).catch((error) => {
                console.log(error);
            });
        };
        $scope.isVerify();
    }]);
</script>