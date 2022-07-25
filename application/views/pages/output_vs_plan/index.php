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
    <title>Hora por hora | Andon</title>
</head>

<style>
    body {
        font-size: 1.5rem;
        display: flex;
        justify-content: center;
        align-content: center;
        text-align: center !important;
        overflow: hidden;
        white-space: nowrap;
    }

    .marquee_table {
        top: 0;
        position: relative;
        animation: slider 20s linear infinite;
        background-color: #fff;
        display: block;
    }

    .marquee_table_2 {
        top: 0;
        position: relative;
        animation: slider 20s linear infinite;
        display: block;

    }

    @keyframes slider {
        0% {
            top: 0
        }

        100% {
            top: -1000px
        }
    }

    .andon {
        position: fixed;
        width: 100vw;
        height: 100vh;
        margin-top: 35rem;
        box-sizing: border-box;
        background-color: #fff;
        z-index: 1 !important;
    }

    .table-andon {
        display: flex;
        white-space: nowrap;
        will-change: transform;
        animation: marquee 30s linear infinite;
    }

    .th-andon {
        border: 0.1rem solid gray;
    }
</style>

<body>
    <main class="container-fluid mt-0 px-0" ng-app="OutputVsPlanApp" ng-controller="OutputVsPlanCtrl">
        <!--ANDON START -->
        <div class="container-fluid andon">
            <div class="table-andon my-4">
                <table class="table table-responsive text-center">
                    <thead>
                        <tr>
                            <!--<th ng-repeat="issue in issues" class="th-andon uppercase {{ issue.status }}">
                                <span><b>{{issue.maquina_centro_trabajo}} -</b></span>
                                {{issue.tipo_error}}
                            </th>-->
                            <th>HOLA</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END ANDON -->

        <div id="table" ng-model="isHidden">
            <!-- TABLE INFO PLANT AND AREA -->
            <table class="table table-responsive px-0 mx-0" style="z-index: 100 !important;">
                <thead>
                    <tr class="text-white text-center">
                        <th class="py-1 uppercase bg-dark">Planta</th>
                        <th class="py-1 uppercase bg-secondary">{{ plan_productions[0].plant_name  }}</th>
                        <th class="py-1 uppercase bg-dark">Area</th>
                        <th class="py-1 uppercase bg-secondary">{{ plan_productions[0].site_name }}</th>
                    </tr>
                </thead>
            </table>
            <!-- END TABLE INFO PLANT AND AREA -->

            <!--FIRST TABLE UPLOAD INFO-->
            <div ng-repeat="plan in plan_productions" class="marquee_table" id="table_one" style="z-index: -1;">
                <table class="table table-responsive mt-1 mb-0">
                    <thead>
                        <tr>
                            <th class="uppercase text-white bg-success">Salida</th>
                            <th class="uppercase table-success">{{ plan.asset_name }}</th>
                            <th class="uppercase text-white bg-success">Estatus del turno</th>

                            <th class="uppercase table-danger" ng-show="plan.shift_status < 84">{{ plan.shift_status }}%</th>
                            <th class="uppercase table-warning" ng-show="plan.shift_status >= 85 && plan.shift_status < 90">{{ plan.shift_status }}%</th>
                            <th class="uppercase table-success" ng-show="plan.shift_status >= 90">{{ plan.shift_status }}%</th>
                        </tr>
                    </thead>
                </table>
                <table class="table table-responsive my-5">
                    <thead>
                        <tr>
                            <th class="uppercase ">HORA</th>
                            <th class="uppercase ">HC</th>
                            <th class="uppercase ">Numero pieza</th>
                            <th class="uppercase ">Numero WO</th>
                            <th class="uppercase ">Plan x hora</th>
                            <th class="uppercase ">Acum Plan</th>
                            <th class="uppercase ">Cantidad Salida</th>
                            <th class="uppercase ">Acum Salida</th>
                            <th class="uppercase ">Causa Interrp</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-if="plan.current_hour_index > 0">
                            <td class="table-secondary"><b> {{ plan.plan_by_hours[plan.current_hour_index - 1].time }}-{{ plan.plan_by_hours[plan.current_hour_index - 1].time_end }} </b></td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned_head_count }}</td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].item }}</td>
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
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].item }}</td>
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
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].item }}</td>
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
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].item }}</td>
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
            <!--END FIRST TABLE UPLOAD INFO-->

            <!--SECOND TABLE UPLOAD INFO-->
            <div ng-repeat="plan in plan_productions" style="z-index: -1;" id="table_two" class="marquee_table_2">
                <table class="table table-responsive mt-3 mb-0">
                    <thead>
                        <tr>
                            <th class="uppercase text-white bg-success">Salida</th>
                            <th class="uppercase table-success">{{ plan.asset_name }}</th>
                            <th class="uppercase text-white bg-success">Shift status</th>

                            <th class="uppercase table-danger" ng-show="plan.shift_status < 84">{{ plan.shift_status }}%</th>
                            <th class="uppercase table-warning" ng-show="plan.shift_status >= 85 && plan.shift_status < 90">{{ plan.shift_status }}%</th>
                            <th class="uppercase table-success" ng-show="plan.shift_status >= 90">{{ plan.shift_status }}%</th>
                        </tr>
                    </thead>
                </table>
                <table class="table table-responsive my-4">
                    <thead>
                        <tr>
                            <th class="uppercase ">HORA</th>
                            <th class="uppercase ">HC</th>
                            <th class="uppercase ">Numero de pieza</th>
                            <th class="uppercase ">Numero de WO</th>
                            <th class="uppercase ">Plan por hora</th>
                            <th class="uppercase ">Acum Plan</th>
                            <th class="uppercase ">Cantidad de Salida</th>
                            <th class="uppercase ">Acum Salida</th>
                            <th class="uppercase ">Causa de interrupcion</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-if="plan.current_hour_index > 0">
                            <td class="table-secondary"><b> {{ plan.plan_by_hours[plan.current_hour_index - 1].time }}-{{ plan.plan_by_hours[plan.current_hour_index - 1].time_end }} </b></td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].planned_head_count }}</td>
                            <td class="table-secondary">{{ plan.plan_by_hours[plan.current_hour_index - 1].item }}</td>
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
                            <td class="table-success">{{ plan.plan_by_hours[plan.current_hour_index].item }}</td>
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
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 1].item }}</td>
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
                            <td class="">{{ plan.plan_by_hours[plan.current_hour_index + 2].item }}</td>
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
            <!--END SECOND TABLE UPLOAD INFO-->
        </div>

        <!--ALERT NO PLAN UPLOAD -->
        <div ng-hide="isHidden" class="alert alert_primary" style="text-align: center;">
            <strong class="uppercase"><bdi>
                    <h1>No hay plan cargado!</h1>
                </bdi>
                <br>
                <h3>No hay un plan activo para esta maquina o punto de medicion.</h3> <br>
            </strong>
            <a type="button" href="<?php echo base_url(); ?>index.php/output_vs_plan/select_monitor" class="btn btn_active uppercase my-5">Regresar</a>
        </div>
        <!--END ALERT NO PLAN UPLOAD -->
    </main>
    <script>
        var table_one = document.getElementById('table_one');
        var table_two = document.getElementById('table_two');

        console.log(table_one)
        var app = angular.module('OutputVsPlanApp', []);
        app.controller('OutputVsPlanCtrl', function($scope, $http, $interval, $timeout) {

            $scope.plan_productions = [];
            $scope.issues = [];

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
                                    echo base_url() . 'output_vs_plan/get_data?monitor_id=' . $monitor_id . '&site_id=' . $site_id;
                                } else {
                                    echo base_url() . 'output_vs_plan/get_data?site_id=' . $site_id . '&plant_id=' . $plant_id;
                                }
                                ?>";

                $http({
                    method: 'get',
                    url: api_url
                }).then(function successCallback(response) {
                    $scope.plan_productions = response.data.production_plans;


                    $scope.plan_productions.forEach(plan => {

                        if ($scope.plan_productions.length <= 2) {
                            if (table_two.style.display === "block") {
                                table_one.style.display = "block";
                            } else {
                                table_one.style.display = "none";
                                table_two.classList.remove('marquee_table_2')
                            }
                        }

                        plan.plan_by_hours.forEach(plan_by_hour => {
                            //console.info(plan_by_hour);
                            //planned_head_count, item, workorder, planned, interruption
                            if (plan_by_hour.planned_head_count == null) plan_by_hour.planned_head_count = '-';
                            if (plan_by_hour.item == null) plan_by_hour.item = '-';
                            if (plan_by_hour.workorder == null) plan_by_hour.workorder = '-';
                            if (plan_by_hour.planned == null) plan_by_hour.planned = '-';
                            if (plan_by_hour.interruption == '') plan_by_hour.interruption = '-';
                        });
                    });

                    //console.log(response.data);
                    $scope.issues = response.data.andon;
                    //$scope.loadAndon();

                    //console.table($scope.plan_productions);
                    if ($scope.plan_productions.length === 0) {
                        $scope.isHidden = false;
                    } else {
                        $scope.isHidden = true;
                    }
                }).catch((e) => {
                    console.log('Error');
                })
            }

            $scope.loadAndon = function() {
                var api_url = "<?php echo base_url() . 'output_vs_plan/get_andon_data'; ?>";

                //console.log(api_url);

                $http({
                    method: 'get',
                    url: api_url
                }).then(function successCallback(response) {
                    $scope.issues = response.data;
                    //console.log($scope.issues);
                }).catch((e) => {
                    console.log('Error' + e);
                })
            };


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