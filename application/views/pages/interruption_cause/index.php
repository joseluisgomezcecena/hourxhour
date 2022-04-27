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

    <?php if ($production_plan->plan_id == null) :
        $this->load->helper('messages');
        show_alert_noplan("<?php echo base_url(); ?>index.php/interruption_cause/select_cell");
    ?>
    <?php else : ?>

        <form action="<?= base_url() ?>interruption_cause" method="post" onsubmit="return validateForm()">

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
                <tbody id="tbody_validation">
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

                        echo "    <td>" . $get_plan['interruption_name'];
                        echo '<input type="number" value="' .  $get_plan['interruption_value'] . '" id="interruption_value_' . $get_plan['plan_by_hour_id'] . '" hidden />';
                        echo "</td>";

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

                            echo ' <input type="number" ng-trim="false" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" required min="0" step="1" class="form-control" placeholder="less time" id="not_planned_interruption_value_' . $get_plan['plan_by_hour_id'] . '" name="not_planned_interruption_value_' . $get_plan['plan_by_hour_id'] . '" value="' . $minutes . '"';
                            echo ' onchange="changed_interruption_value(this, ' . $get_plan['plan_by_hour_id'] . ')"';
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
            document.getElementById(identifier).value = 0;
            document.getElementById(identifier).focus();
        } else {
            console.log('not number ' + parent.value);
            document.getElementById(identifier).disabled = true;
            document.getElementById(identifier).value = '';
        }
    }

    function changed_interruption_value(parent, plan_by_hour_id) {

        //console.log('...' + plan_by_hour_id);
        //console.log(parent.value);
        var interrumption_minutes = Math.round(document.getElementById("interruption_value_" + plan_by_hour_id).value * 60.0);
        var not_planned_interrumption_minutes = parent.value;
        var sum = Number(interrumption_minutes) + Number(not_planned_interrumption_minutes);

        console.log('int ' + interrumption_minutes + ' not planned ' + not_planned_interrumption_minutes);

        if (not_planned_interrumption_minutes > 60) {
            swal("Incorrect Value Given", "The minutes of your interruption are more than 60, Correct it please!!", "error");
            parent.value = '0';
            //parent.focus();
            return;
        } else if (sum > 60) {
            swal("Incorrect Value Given (" + parent.value + ")", "The interruption minutes are bigger than the max allowed for the hour!! The sum of minutes is " + sum, "error");
            //parent.value = '0';
            parent.focus();
        }

    }

    function validateForm() {

        var trs = document.querySelectorAll('#tbody_validation tr'),
            i;
        for (i = 0; i < trs.length; ++i) {

            var totalMinutes = 0;

            //console.log(trs[i].children[0].textContent);

            td_planned_interruption = trs[i].children[8];
            var input_interruption = td_planned_interruption.getElementsByTagName("input")[0];

            if (input_interruption.value != '') {
                //console.log(input_interruption.id);
                totalMinutes += Math.round(input_interruption.value * 60.0);
            }


            td_interruption_cause = trs[i].children[9];

            td_less_time = trs[i].children[10];
            var not_planned_input_interruption = td_less_time.getElementsByTagName("input")[0];

            if (td_interruption_cause.getElementsByTagName("select")[0] != undefined) {
                var select = td_interruption_cause.getElementsByTagName("select")[0];

                if (isNaN(select.value) == false) {
                    //console.log('number detected ' + select.value);
                    //Si hay una causa de interrupcion seleccionada

                    if (isNaN(not_planned_input_interruption.value) == false) {
                        if (!(not_planned_input_interruption.value > 0 && not_planned_input_interruption.value <= 60)) {
                            swal("Incorrect Value Given (" + not_planned_input_interruption.value + ")", "The interruption minutes must be given between 1 and 60 minutes", "error");
                            return false;
                        }
                    } else {
                        //Si el valor no es numero
                        swal("Incorrect Value Given (" + not_planned_input_interruption.value + ")", "The interruption minutes must be given between 1 and 60 minutes", "error");
                        return false;
                    }
                }

            }




            if (not_planned_input_interruption != null) {
                //console.log(not_planned_input_interruption.value);
                totalMinutes += Number(not_planned_input_interruption.value);
            }



            if (totalMinutes != 0) {

                if (totalMinutes > 60) {
                    console.log('mins ' + totalMinutes);
                    swal("Incorrect Value Given (" + not_planned_input_interruption.value + ")", "The interruption minutes in hour " + trs[i].children[0].textContent + " are bigger than the max allowed for the hour!! The sum of minutes is " + totalMinutes, "error");
                    return false;
                }
            }

        }

        return true;
    }
</script>