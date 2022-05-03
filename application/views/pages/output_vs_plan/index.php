<!doctype html>
<html lang="en" class="menu_branded theme-sky font-poppins" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon/favicon.ico">
    <link rel="stylesheet" href="<?php echo  base_url() ?>assets/bootstrap-5.0.2/bootstrap.min.css">
    <script src='<?= base_url() ?>assets/angular-1.8.2/angular.min.js'></script>
    <script src="<?php echo  base_url() ?>assets/js/jquery.min.js"></script>
    <title>Hour By Hour | Andon</title>
</head>

<style>
    body {
        font-size: 1.2rem;
        display: flex;
        justify-content: center;
        align-content: center;
        text-align: center !important;
        overflow-x: hidden;
    }

    .andon {
        position: relative;
        width: 100vw;
        height: 5rem;
        padding: 1rem;
    }

    .table-andon {
        display: flex;
        white-space: nowrap;
        will-change: transform;
        animation: marquee 30s linear infinite;
    }

    @keyframes marquee {
        0% {
            transform: translateX(100vw);
            visibility: visible;
        }

        99% {
            transform: translateX(-100vw);
            visibility: hidden;
        }

        100% {
            transform: translateX(100vw);
            visibility: hidden;
        }
    }
</style>

<body>
    <main class="container-fluid mt-0 px-0" ng-app="OutputVsPlanApp" ng-controller="OutputVsPlanCtrl">
        <div id="table" ng-model="isHidden">
            <table class="table table-responsive px-0 mx-0">
                <thead>
                    <tr class="text-white text-center">
                        <th class="py-1 uppercase bg-dark">Plant</th>
                        <th class="py-1 uppercase bg-secondary">{{ plan_productions[0].plant_name  }}</th>
                        <th class="py-1 uppercase bg-dark">Area</th>
                        <th class="py-1 uppercase bg-secondary">{{ plan_productions[0].site_name }}</th>
                    </tr>
                </thead>
            </table>
            <div id="table-container" ng-repeat="plan in plan_productions">
                <table class="table table-responsive mt-1 mb-0">
                    <thead>
                        <tr>
                            <th class="uppercase text-white bg-success">Output</th>
                            <th class="uppercase table-success">{{ plan.asset_name }}</th>
                            <th class="uppercase text-white bg-success">Shift status</th>

                            <th class="uppercase table-danger" ng-show="plan.shift_status < 84">{{ plan.shift_status }}%</th>
                            <th class="uppercase table-warning" ng-show="plan.shift_status >= 85 && plan.shift_status < 90">{{ plan.shift_status }}%</th>
                            <th class="uppercase table-success" ng-show="plan.shift_status >= 90">{{ plan.shift_status }}%</th>
                        </tr>
                    </thead>
                </table>

                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th class="uppercase ">HOUR</th>
                            <th class="uppercase ">HC</th>
                            <th class="uppercase ">Item Number</th>
                            <th class="uppercase ">WO Number</th>
                            <th class="uppercase ">Plan By Hour</th>
                            <th class="uppercase ">CUM Plan</th>
                            <th class="uppercase ">Output QTY</th>
                            <th class="uppercase ">CUM Output</th>
                            <th class="uppercase ">Interruption Cause</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-if="plan.current_hour_index > 0">
                            <td class="table-secondary"><b> {{ plan.plan_by_hours[plan.current_hour_index - 1].time }}-{{ plan.plan_by_hours[plan.current_hour_index - 1].time_end }} </b></td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned_head_count }}</td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].item_number }}</td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].workorder }}</td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned }}</td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned_sum }}</td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].completed }}</td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].completed_sum }}</td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].interruption }}</td>
                        </tr>
                        <tr>
                            <td class="table-success"><b> {{ plan.plan_by_hours[plan.current_hour_index].time }}-{{ plan.plan_by_hours[plan.current_hour_index].time_end }} </b></td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned_head_count }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].item_number }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].workorder }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned_sum }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].completed }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].completed_sum }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index ].interruption }} </td>
                        </tr>
                        <tr ng-if="(plan.current_hour_index + 1) < plan.plan_by_hours.length">
                            <td class=""><b> {{ plan.plan_by_hours[plan.current_hour_index + 1].time }}-{{ plan.plan_by_hours[plan.current_hour_index + 1].time_end }} </b></td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned_head_count }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].item_number }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].workorder }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned_sum }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].completed }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].completed_sum }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1 ].interruption }} </td>
                        </tr>
                        <tr ng-if="(plan.current_hour_index + 2) < plan.plan_by_hours.length">
                            <td class=""><b> {{ plan.plan_by_hours[plan.current_hour_index + 2].time }}-{{ plan.plan_by_hours[plan.current_hour_index + 2].time_end }} </b></td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned_head_count }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].item_number }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].workorder }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned_sum }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].completed }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].completed_sum }}</td>
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].interruption }} </td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="container-fluid andon">
                <div class="table-andon">
                    <table class="table table-responsive text-center">
                        <thead>
                            <tr>
                                <th class="uppercase bg-warning">
                                    <span><b>TIP 32 -</b></span>
                                    SET UP
                                </th>
                                <th class="uppercase bg-danger">
                                    <span><b>BOY25 -</b></span>
                                    SET UP
                                </th>
                                <th class="uppercase bg-danger">
                                    <span><b>TIP 32 -</b></span>
                                    SET UP
                                </th>
                                <th class="uppercase bg-warning">
                                    <span><b>TIP 32 -</b></span>
                                    FALTA DE CLARIDAD EN SOP
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div ng-hide="isHidden" class="alert alert_primary" style="text-align: center;">
            <strong class="uppercase"><bdi>
                    <h1>No plan loaded!</h1>
                </bdi>
                <br>
                <h3>There isn't an active production plan for this machine/point.</h3> <br>
            </strong>
            <a type="button" href="<?php echo base_url(); ?>index.php/output_vs_plan/select_monitor" class="btn btn_active uppercase my-5">Go back</a>
        </div>
    </main>
    <!--<main class="container-fluid  mt-0 px-0" ng-app="OutputVsPlanApp" ng-controller="OutputVsPlanCtrl">
        <div id="table" ng-model="isHidden">
            <div>
                <table class="table table-responsive px-0 mx-0">
                    <thead>
                        <tr class="text-white text-center">
                            <th class="py-1 uppercase bg-dark">Plant</th>
                            <th class="py-1 uppercase bg-secondary">{{ plan_productions[0].plant_name  }}</th>
                            <th class="py-1 uppercase bg-dark">Area</th>
                            <th class="py-1 uppercase bg-secondary">{{ plan_productions[0].site_name }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <div id="table-container" class="mb-5" ng-repeat="plan in plan_productions">
                            <table class="table table-responsive mt-1 mb-0">
                                <thead>
                                    <tr>
                                        <th class="uppercase text-white bg-success">Output</th>
                                        <th class="uppercase table-success">{{ plan.asset_name }}</th>
                                        <th class="uppercase text-white bg-success">Shift status</th>

                                        <th class="uppercase table-danger" ng-show="plan.shift_status < 84">{{ plan.shift_status }}%</th>
                                        <th class="uppercase table-warning" ng-show="plan.shift_status >= 85 && plan.shift_status < 90">{{ plan.shift_status }}%</th>
                                        <th class="uppercase table-success" ng-show="plan.shift_status >= 90">{{ plan.shift_status }}%</th>
                                    </tr>
                                </thead>
                            </table>

                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th class="uppercase ">HOUR</th>
                                        <th class="uppercase ">HC</th>
                                        <th class="uppercase ">Item Number</th>
                                        <th class="uppercase ">WO Number</th>
                                        <th class="uppercase ">Plan By Hour</th>
                                        <th class="uppercase ">CUM Plan</th>
                                        <th class="uppercase ">Output QTY</th>
                                        <th class="uppercase ">CUM Output</th>
                                        <th class="uppercase ">Interruption Cause</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-if="plan.current_hour_index > 0">
                                        <td class="table-secondary"><b> {{ plan.plan_by_hours[plan.current_hour_index - 1].time }}-{{ plan.plan_by_hours[plan.current_hour_index - 1].time_end }} </b></td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned_head_count }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].item_number }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].workorder }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned_sum }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].completed }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].completed_sum }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].interruption }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-success"><b> {{ plan.plan_by_hours[plan.current_hour_index].time }}-{{ plan.plan_by_hours[plan.current_hour_index].time_end }} </b></td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned_head_count }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].item_number }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].workorder }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned_sum }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].completed }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].completed_sum }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index ].interruption }} </td>
                                    </tr>
                                    <tr ng-if="(plan.current_hour_index + 1) < plan.plan_by_hours.length">
                                        <td class=""><b> {{ plan.plan_by_hours[plan.current_hour_index + 1].time }}-{{ plan.plan_by_hours[plan.current_hour_index + 1].time_end }} </b></td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned_head_count }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].item_number }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].workorder }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned_sum }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].completed }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].completed_sum }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1 ].interruption }} </td>
                                    </tr>
                                    <tr ng-if="(plan.current_hour_index + 2) < plan.plan_by_hours.length">
                                        <td class=""><b> {{ plan.plan_by_hours[plan.current_hour_index + 2].time }}-{{ plan.plan_by_hours[plan.current_hour_index + 2].time_end }} </b></td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned_head_count }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].item_number }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].workorder }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned_sum }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].completed }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].completed_sum }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].interruption }} </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div id="table-container" class="mb-5" ng-repeat="plan in plan_productions">
                            <table class="table table-responsive mt-1 mb-0">
                                <thead>
                                    <tr>
                                        <th class="uppercase text-white bg-success">Output</th>
                                        <th class="uppercase table-success">{{ plan.asset_name }}</th>
                                        <th class="uppercase text-white bg-success">Shift status</th>

                                        <th class="uppercase table-danger" ng-show="plan.shift_status < 84">{{ plan.shift_status }}%</th>
                                        <th class="uppercase table-warning" ng-show="plan.shift_status >= 85 && plan.shift_status < 90">{{ plan.shift_status }}%</th>
                                        <th class="uppercase table-success" ng-show="plan.shift_status >= 90">{{ plan.shift_status }}%</th>
                                    </tr>
                                </thead>
                            </table>

                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th class="uppercase ">HOUR</th>
                                        <th class="uppercase ">HC</th>
                                        <th class="uppercase ">Item Number</th>
                                        <th class="uppercase ">WO Number</th>
                                        <th class="uppercase ">Plan By Hour</th>
                                        <th class="uppercase ">CUM Plan</th>
                                        <th class="uppercase ">Output QTY</th>
                                        <th class="uppercase ">CUM Output</th>
                                        <th class="uppercase ">Interruption Cause</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-if="plan.current_hour_index > 0">
                                        <td class="table-secondary"><b> {{ plan.plan_by_hours[plan.current_hour_index - 1].time }}-{{ plan.plan_by_hours[plan.current_hour_index - 1].time_end }} </b></td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned_head_count }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].item_number }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].workorder }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned_sum }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].completed }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].completed_sum }}</td>
                                        <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].interruption }}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-success"><b> {{ plan.plan_by_hours[plan.current_hour_index].time }}-{{ plan.plan_by_hours[plan.current_hour_index].time_end }} </b></td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned_head_count }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].item_number }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].workorder }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned_sum }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].completed }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].completed_sum }}</td>
                                        <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index ].interruption }} </td>
                                    </tr>
                                    <tr ng-if="(plan.current_hour_index + 1) < plan.plan_by_hours.length">
                                        <td class=""><b> {{ plan.plan_by_hours[plan.current_hour_index + 1].time }}-{{ plan.plan_by_hours[plan.current_hour_index + 1].time_end }} </b></td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned_head_count }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].item_number }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].workorder }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned_sum }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].completed }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].completed_sum }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1 ].interruption }} </td>
                                    </tr>
                                    <tr ng-if="(plan.current_hour_index + 2) < plan.plan_by_hours.length">
                                        <td class=""><b> {{ plan.plan_by_hours[plan.current_hour_index + 2].time }}-{{ plan.plan_by_hours[plan.current_hour_index + 2].time_end }} </b></td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned_head_count }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].item_number }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].workorder }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned_sum }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].completed }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].completed_sum }}</td>
                                        <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].interruption }} </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid andon">
                <div class="table-andon">
                    <table class="table table-responsive text-center">
                        <thead>
                            <tr>
                                <th class="uppercase bg-warning">
                                    <span><b>TIP 32 -</b></span>
                                    SET UP
                                </th>
                                <th class="uppercase bg-danger">
                                    <span><b>BOY25 -</b></span>
                                    SET UP
                                </th>
                                <th class="uppercase bg-danger">
                                    <span><b>TIP 32 -</b></span>
                                    SET UP
                                </th>
                                <th class="uppercase bg-warning">
                                    <span><b>TIP 32 -</b></span>
                                    FALTA DE CLARIDAD EN SOP
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
    </main>-->
    <script>
        var app = angular.module('OutputVsPlanApp', []);
        app.controller('OutputVsPlanCtrl', function($scope, $http, $interval, $timeout) {
            $scope.plan_productions = [];
            $scope.isHidden = true;

            $scope.init = function() {
                $scope.loadData();
            }

            //Actualizar cada 5 minutos...
            var theInterval = $interval(function() {
                $scope.loadData();
            }.bind(this), 5 * 60 * 1000);

            $scope.$on('$destroy', function() {
                $interval.cancel(theInterval)
            });

            $scope.loadData = function() {

                var api_url = "<?php
                                if (isset($monitor_id)) {
                                    echo base_url() . 'output_vs_plan/get_data?monitor_id=' . $monitor_id;
                                } else {
                                    echo base_url() . 'output_vs_plan/get_data?site_id=' . $site_id . '&plant_id=' . $plant_id;
                                }
                                ?>";

                $http({
                    method: 'get',
                    url: api_url
                }).then(function successCallback(response) {
                    $scope.plan_productions = response.data;

                    $scope.plan_productions.forEach(plan => {

                        plan.plan_by_hours.forEach(plan_by_hour => {
                            console.log(plan_by_hour);
                            //planned_head_count, item_number, workorder, planned, interruption
                            if (plan_by_hour.planned_head_count == null) plan_by_hour.planned_head_count = '-';
                            if (plan_by_hour.item_number == null) plan_by_hour.item_number = '-';
                            if (plan_by_hour.workorder == null) plan_by_hour.workorder = '-';
                            if (plan_by_hour.planned == null) plan_by_hour.planned = '-';
                            if (plan_by_hour.interruption == '') plan_by_hour.interruption = '-';
                        });
                    });

                    console.log($scope.plan_productions);
                    if ($scope.plan_productions.length === 0) {
                        $scope.isHidden = false;
                    } else {
                        $scope.isHidden = true;
                    }
                }).catch((e) => {
                    console.log('Error');
                })
            }


            $scope.init();
        });
    </script>

    <!-- Scripts -->
    <script src="<?php echo  base_url() ?>assets/js/vendor.js"></script>
    <script src="<?php echo  base_url() ?>assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>