<style>
    th {
        color: black;
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
    }
</style>
<section class="breadcrumb">
    <h1><?= $title ?></h1>
    <ul>
        <li><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="divider la la-arrow-right"></li>
        <li><?= $title ?></li>
    </ul>
    <!--<?= json_encode($production_plan) ?>-->
    <table class="table w-full mt-3">
        <thead>
            <tr>
                <th class="uppercase table-green">Plant</th>
                <th class="uppercase table-success"><?= $production_plan->plant_name ?></th>
                <th class="uppercase table-green">Area</th>
                <th class="uppercase table-success"><?= $production_plan->site_name ?></th>
                <th class="uppercase table-green">Output</th>
                <th class="uppercase table-success"><?= $production_plan->asset_name ?></th>
                <th class="uppercase table-green">Shift status</th>
                <th class="uppercase table-success" ng-model="production_plan.shift_id"></th>
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
                <th class="uppercase table-green">Less Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($production_plan->plan_by_hours as $get_plan) {
                $start_time = date(TIME_FORMAT, strtotime($get_plan['time']));
                $end_time = date(TIME_FORMAT, strtotime($get_plan['time_end']));

                echo "
                    <tr>
                    <td><b>${start_time} - ${end_time}</b></td>
                    <td>${get_plan['planned_head_count']}</td>
                    <td>${get_plan['item_number']}</td>
                    <td>${get_plan['workorder']}</td>
                    <td>${get_plan['planned']}</td>
                    <td>--</td>
                    <td>${get_plan['completed']}</td>
                    <td>-</td>
                    <td></td>
                    <td></td>
                </tr>
                ";
            }
            ?>
        </tbody>
    </table>
</section>