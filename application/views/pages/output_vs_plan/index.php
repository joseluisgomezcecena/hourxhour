<!doctype html>
<html lang="en" class="menu_branded theme-sky font-poppins" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon/favicon.ico">

    <!--data tables-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom_datatables_styles.css">

    <script src='<?= base_url() ?>assets/angular-1.8.2/angular.min.js'></script>
    <script src="<?php echo  base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo  base_url() ?>assets/js/sweetalert.min.js"></script>
    <title>Hour By Hour | Andon</title>
</head>
<style>
    body {
        overflow: hidden;
    }

    th {
        color: black;
        font-size: 1.2rem;
    }

    .table-success {
        background-color: #b8efc1 !important;
    }

    .table-green {
        background-color: #059669;
    }

    .table-warning {
        background-color: #ede4b6 !important;
    }

    .table-danger {
        background-color: #edb6b6 !important;
    }

    .table-gray {
        background-color: #e0e0e0 !important;
    }

    td {
        text-align: center;
        font-size: 1.5rem;
    }

    #table {
        white-space: nowrap;
        animation: marquee 10s ease-out infinite alternate;
        transition: all .2s ease-out;
        display: inline-block;
    }

    .table-container {
        position: relative;
        margin-top: 5px;
        animation: marquee_container 5s linear infinite;
    }

    @keyframes marquee_container {

        0%,
        50% {
            top: 0%;
        }

        50.01%,
        100% {
            top: 100%;
        }
    }

    @keyframes marquee {
        0% {
            transform: translateY(0)
        }

        100% {
            transform: translateY(-100%)
        }
    }

    .divider {
        border: 2px dotted #059669;
        width: 100%;
        margin-top: 3rem;
        margin-bottom: 3rem;

    }
</style>

<body>
    <main class="workspace" ng-app="OutputVsPlanApp" ng-controller="OutputVsPlanCtrl">
        <div id="table" ng-model="isHidden" style="margin-top: -6rem;">
            <div id="table-container" ng-repeat="plan in plan_productions">
                <div class="divider"></div>
                <table class="table w-full mt-3">
                    <thead>
                        <tr ng-switch="">
                            <th class="uppercase table-green">Plant</th>
                            <th class="uppercase table-success">{{ plan.plant_name }}</th>
                            <th class="uppercase table-green">Area</th>
                            <th class="uppercase table-success">{{ plan.site_name }}</th>
                            <th class="uppercase table-green">Output</th>
                            <th class="uppercase table-success">{{ plan.asset_name }}</th>
                            <th class="uppercase table-green">Shift status</th>

                            <th class="uppercase table-danger" ng-show="plan.shift_status < 84">{{ plan.shift_status }}%</th>
                            <th class="uppercase table-warning" ng-show="plan.shift_status >= 85 && plan.shift_status < 90">{{ plan.shift_status }}%</th>
                            <th class="uppercase table-success" ng-show="plan.shift_status >= 90">{{ plan.shift_status }}%</th>
                        </tr>
                    </thead>
                </table>

                <table class="table w-full mt-5">
                    <thead>
                        <tr>
                            <th class="uppercase table-green">HR</th>
                            <th class="uppercase table-green">HC</th>
                            <th class="uppercase table-green">Item Number</th>
                            <th class="uppercase table-green">WO Number</th>
                            <th class="uppercase table-green">Plan By Hour</th>
                            <th class="uppercase table-green">CUM Plan</th>
                            <th class="uppercase table-green">Output QTY</th>
                            <th class="uppercase table-green">CUM Output</th>
                            <th class="uppercase table-green">Interruption Cause</th>

                        </tr>
                    </thead>
                    <tbody>

                        <!-- Row anterior -->
                        <tr ng-if="plan.current_hour_index > 0">
                            <td class="table-gray"><b> {{ plan.plan_by_hours[plan.current_hour_index - 1].time }}-{{ plan.plan_by_hours[plan.current_hour_index - 1].time_end }} </b></td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned_head_count }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index - 1].item_number }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index - 1].workorder }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned_sum }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index - 1].completed }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index - 1].completed_sum }}</td>
                            <td class="table-gray">Pending</td>
                        </tr>

                        <!-- Current Row -->
                        <tr>
                            <td class="table-success"><b> {{ plan.plan_by_hours[plan.current_hour_index].time }}-{{ plan.plan_by_hours[plan.current_hour_index].time_end }} </b></td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned_head_count }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].item_number }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].workorder }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].planned_sum }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].completed }}</td>
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].completed_sum }}</td>
                            <td class="table-success">Pending</td>
                        </tr>

                        <!-- Next -->
                        <tr ng-if="(plan.current_hour_index + 1) < plan.plan_by_hours.length">
                            <td class="table-gray"><b> {{ plan.plan_by_hours[plan.current_hour_index + 1].time }}-{{ plan.plan_by_hours[plan.current_hour_index + 1].time_end }} </b></td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned_head_count }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 1].item_number }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 1].workorder }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 1].planned_sum }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 1].completed }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 1].completed_sum }}</td>
                            <td class="table-gray">Pending</td>
                        </tr>

                        <tr ng-if="(plan.current_hour_index + 2) < plan.plan_by_hours.length">
                            <td class="table-gray"><b> {{ plan.plan_by_hours[plan.current_hour_index + 2].time }}-{{ plan.plan_by_hours[plan.current_hour_index + 2].time_end }} </b></td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned_head_count }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 2].item_number }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 2].workorder }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 2].planned_sum }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 2].completed }}</td>
                            <td class="table-gray">{{ plan.plan_by_hours[plan.current_hour_index + 2].completed_sum }}</td>
                            <td class="table-gray">Pending</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div ng-hide="isHidden" class="alert alert_primary" style="text-align: center;">
            <strong class="uppercase"><bdi>
                    <h1>No plan loaded!</h1>
                </bdi>
                <br>
                <h3>There isn't an active production plan for this machine/point.</h3> <br>
            </strong>
            <a type="button" href="<?php echo base_url(); ?>index.php/output_vs_plan/select_site" class="btn btn_secondary uppercase my-5">Go back</a>
        </div>
    </main>
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

                $http({
                    method: 'get',
                    url: '<?php echo base_url() . 'output_vs_plan/get_data?site_id=' . $site_id . '&plant_id=' . $plant_id; ?>'
                }).then(function successCallback(response) {
                    $scope.plan_productions = response.data;
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

</body>

</html>