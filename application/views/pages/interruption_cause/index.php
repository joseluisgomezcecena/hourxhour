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

    <?php if ($production_plan->plan_id == null) : ?>
        <!--<h2>There isn't an active production plan for this machine/point.</h2>-->

        <div class="alert alert_primary" style="text-align: center;">
            <strong class="uppercase"><bdi>
                    No plan loaded!
                </bdi>
                <br> There isn't an active production plan for this machine/point. <br>
            </strong>
            <a type="button" href="<?php echo base_url(); ?>index.php/interruption_cause/select_cell" class="btn btn_secondary uppercase my-5">Go back</a>
        </div>

    <?php else : ?>

        <form action="<?= base_url() ?>interruption_cause" method="post">

            <input type="text" name="plant_id" value="<?= $production_plan->plant_id ?>" hidden />
            <input type="text" name="site_id" value="<?= $production_plan->site_id ?>" hidden />

            <table class="table w-full mt-3">
                <thead>
                    <tr>
                        <th class="uppercase table-green">Plant</th>
                        <th class="uppercase table-success"><?= $production_plan->plant_name ?></th>
                        <th class="uppercase table-green">Area</th>
                        <th class="uppercase table-success"><?= $production_plan->site_name ?></th>
                        <th class="uppercase table-green">Output</th>
                        <th class="uppercase table-success"><?= $production_plan->asset_name ?></th>
                        <th class="uppercase table-green">Shift Status</th>
                        <th class="uppercase table-success">
                            <?php
                            $sum_planned = 0;
                            $sum_completed = 0;
                            foreach ($production_plan->plan_by_hours as $get_plan) {

                                $sum_planned += $get_plan['planned'];
                                $sum_completed += $get_plan['completed'];
                            }
                            //planeados 100%
                            //complete
                            echo intval(($sum_completed * 100) /  $sum_planned) . '%';

                            ?>
                        </th>
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
                        <th class="uppercase table-green">Planned Interruption</th>
                        <th class="uppercase table-green">Interruption Cause</th>
                        <th class="uppercase table-green">Less Time in Minutes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sum_planned = 0;
                    $sum_completed = 0;

                    foreach ($production_plan->plan_by_hours as $get_plan) {
                        $start_time = date(HOUR_MINUTE_FORMAT, strtotime($get_plan['time']));
                        $end_time = date(HOUR_MINUTE_FORMAT, strtotime($get_plan['time_end']));
                        $sum_planned += $get_plan['planned'];
                        $sum_completed += $get_plan['completed'];


                        echo '<tr>';
                        echo "    <td><b>${start_time} - ${end_time}</b></td>";
                        echo "    <td>${get_plan['planned_head_count']}</td>";
                        echo "    <td>${get_plan['item_number']}</td>";
                        echo "    <td>${get_plan['workorder']}</td>";
                        echo "    <td>${get_plan['planned']}</td>";
                        echo "    <td>${sum_planned}</td>";
                        echo "    <td>${get_plan['completed']}</td>";
                        echo "    <td>${sum_completed}</td>";
                        echo "    <td>${get_plan['interruption_name']}</td>";

                        echo '    <td>';
                        if ($get_plan['planned']) {
                            echo ' <select type="text" class="form-control" name="not_planned_interruption_id_' . $get_plan['plan_by_hour_id'] . '" onchange="changed_interruption_id(this, ' . $get_plan['plan_by_hour_id'] . ')"  >';

                            echo '<option selected>select cause</option>';
                            foreach ($not_planned_interruptions as $int) {
                                $selected = '';
                                if ($get_plan['not_planned_interruption_id'] == $int->interruption_id)
                                    $selected = 'selected';

                                echo ' <option value="' . $int->interruption_id . '" ' . $selected . '>' . $int->interruption_name . '</option>';
                            }
                            echo ' </select>';
                        }
                        echo '    </td>';

                        echo '    <td>';
                        if ($get_plan['planned']) {

                            if ($get_plan['not_planned_interruption_value'] == null)
                                $minutes = null;
                            else
                                $minutes = round(floatval($get_plan['not_planned_interruption_value']) * 60.0, 0);

                            echo ' <input type="number" min="1" max="60" step="1" class="form-control" placeholder="less time" id="not_planned_interruption_value_' . $get_plan['plan_by_hour_id'] . '" name="not_planned_interruption_value_' . $get_plan['plan_by_hour_id'] . '" value="' . $minutes . '"';

                            if ($minutes == 0)
                                echo 'disabled';

                            echo '>';
                        }
                        echo '    </td>';


                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>

            <div class="flex justify-end mt-5">
                <button type="submit" class="btn btn_success uppercase">
                    <span class="la la-save ltr:mr-2 rtl:ml-2"></span>
                    Save
                </button>
            </div>

        </form>
    <?php endif; ?>


</section>

<script>
    function changed_interruption_id(parent, plan_by_hour_id) {

        let identifier = "not_planned_interruption_value_" + plan_by_hour_id;

        if (!isNaN(parent.value)) {
            console.log(parent.value);
            document.getElementById(identifier).disabled = false;
            document.getElementById(identifier).value = 15;
            document.getElementById(identifier).focus();
        } else {
            console.log('not number ' + parent.value);
            document.getElementById(identifier).disabled = true;
            document.getElementById(identifier).value = '';
        }



    }
</script>