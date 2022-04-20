<style>
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
</style>
<section style="margin-top: -6rem;" ng-app="OutputVsPlanApp" ng-controller="OutputVsPlanCtrl">

    <div ng-repeat="plan in plan_productions">

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
                    <th class="uppercase table-green" ng-show="plan.shift_status >= 90">{{ plan.shift_status }}%</th>

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


</section>


<script>
    var app = angular.module('OutputVsPlanApp', []);

    app.controller('OutputVsPlanCtrl', function($scope, $http) {

        //$scope.firstName = "John";
        //$scope.lastName = "Doe";
        $scope.plan_productions = [];

        $scope.init = function() {
            $scope.loadData();
        }

        $scope.loadData = function() {

            $http({
                method: 'get',
                url: '<?php echo base_url() . 'output_vs_plan/get_data?site_id=' . $site_id . '&plant_id=' . $plant_id; ?>'
            }).then(function successCallback(response) {
                $scope.plan_productions = response.data;
                console.log($scope.plan_productions);
            });
        }


        $scope.init();

    });
</script>