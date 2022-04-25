<style>
    .table-row-shift-one {
        background-color: #B8DEF2 !important;
    }

    .table-row-shift-two {
        background-color: #b8efc1 !important;
    }

    .table-row-shift-three {
        background-color: #edb6b6 !important;
    }

    .table-row-group {
        background-color: #4B5563 !important;
        color: white;
    }
</style>
<!-- Breadcrumb -->
<section class="breadcrumb">
    <h1><?= $title ?></h1>
    <ul>
        <li><a href="#">Pages</a></li>
        <li class="divider la la-arrow-right"></li>
        <li><?= $title ?></li>
    </ul>
</section>
<div class="grid lg:grid-cols-1 gap-5">
    <!-- Content -->
    <div class="lg:col-span-3 xl:col-span-3" ng-app="customReportApp" ng-controller="customReport">
        <div class="card p-5">
            <div class="mt-5">
                <div class="grid lg:grid-cols-3 gap-5 my-5">
                    <div class="text-success">
                        <label for="start_date" class="mx-5"><b>Start date</b></label>
                        <input type="date" ng-model="start_date" name="start_date" id="start_date">
                    </div>
                    <div class="text-success">
                        <label for="end_date" class="mx-5"><b>End date</b></label>
                        <input type="date" ng-model="end_date" name="end_date" id="end_date">
                    </div>
                    <div>
                        <button type="button" class="btn btn_info uppercase" ng-click="submit()">Search</button>
                    </div>
                </div>
                <table id="report-table" class="table table-auto w-full mb-5">
                    <thead>
                        <tr>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Plant</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Cell</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Machine</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase table-row-shift-one">Planned (Shift one)</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase table-row-shift-one">Completed (Shift one)</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase table-row-shift-two"> Planned (Shift two)</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase table-row-shift-two">Completed (Shift two)</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase table-row-shift-three">Planned (Shift three)</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase table-row-shift-three">Completed (Shift three)</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Total Planned</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Total Completed</th>
							<th style="font-size: 11px !important;" class="text-center uppercase">% vs Plan</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($custom_report as $report) : ?>
                            <tr>
                                <td class="text-center"><?= $report['plant_name'] ?></td>
                                <td class="text-center"><?= $report['site_name'] ?></td>
                                <td class="text-center"><?= $report['asset_name'] ?></td>

                                <td class="text-center"><?= $report['planned_shift_one']  ?></td>
                                <td class="text-center"><?= $report['completed_shift_one']  ?></td>

                                <td class="text-center"><?= $report['planned_shift_two'] ?></td>
                                <td class="text-center"><?= $report['completed_shift_two'] ?></td>

                                <td class="text-center"><?= $report['planned_shift_three'] ?></td>
                                <td class="text-center"><?= $report['completed_shift_three'] ?></td>

                                <td class="text-center"><?= $report['total_planned'] ?></td>
                                <td class="text-center"><?= $report['total_completed'] ?></td>

								<td class="text-center">
									<?php
									if($report['total_completed']>0)
									{
										echo ceil($report['total_completed']/$report['total_planned'] * 100);
									}
									else
									{
										echo "0";
									}
									?>
									%
								</td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#report-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "columnDefs": [{
                "visible": false,
                "targets": 0
            }],
            "order": [
                [0, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(0, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group table-row-group"><td colspan="11"><b>' + group + '</b></td></tr>'
                        );

                        last = group;
                    }
                });
            }
        });

        // Order by the grouping
        $('#report-table tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
    });

    var fetch = angular.module('customReportApp', []);
    fetch.controller('customReport', ['$scope', '$http', '$httpParamSerializerJQLike', function($scope, $http, $httpParamSerializerJQLike) {

        $scope.start_date = null;
        $scope.end_date = null;

        $scope.submit = function() {
            var start = $scope.start_date.toISOString().split('T')[0] + ' 0:00:00';
            var end = $scope.end_date.toISOString().split('T')[0] + ' 23:59:59';
            window.location = '<?php echo base_url(); ?>index.php/custom_report?start_date=' + start + '&end_date=' + end;
        //   window.location.assign();
        };
    }]);
</script>
