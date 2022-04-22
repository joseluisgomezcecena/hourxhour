<style>
    .table-success {
        background-color: #b8efc1 !important;
    }

    .table-warning {
        background-color: #ede4b6 !important;
    }

    .table-danger {
        background-color: #edb6b6 !important;
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
    <div class="grid lg:grid-cols-1 gap-5 mt-5">
        <div style="display: flex; justify-content:flex-end;">
            <h3 id='ct5'></h3>
        </div>
        <!-- Summaries -->
        <div class="grid sm:grid-cols-3 gap-5 my-5">

            <div class="card">
                <h3 class="text-center mt-5 mb-5">Moldeo</h3>
                <?php
                if (count($moldeo) === 0) {
                    echo '<div style="padding-left:0.8rem; padding-right:0.8rem;">';
                    $this->load->helper('messages');
                    show_alert_noplan(null);
                    echo '</div>';
                } else {
                    echo '
                    <table class="table w-full mt-3 text-center">
                        <thead>
                            <tr>
                                <th class="text-center uppercase">Area</th>
                                <th class="text-center uppercase">Output</th>
                                <th class="text-center uppercase">Shift Status</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    foreach ($moldeo as $m) :

                        if (date("H:i:s") >= "06:00:00" && date("H:i:s") < "16:00:00") {
                            if ($m['planned_shift_one'] > 0) {
                                $percentm = ceil(($m['completed_shift_one'] / $m['planned_shift_one']) * 100);
                            } else {
                                $percentm = 0;
                            }
                        } elseif (date("H:i:s") >= "16:00:00" && date("H:i:s") < "23:59:59") {
                            if ($m['planned_shift_two'] > 0) {
                                $percentm = ceil(($m['completed_shift_two'] / $m['planned_shift_two']) * 100);
                            } else {
                                $percentm = 0;
                            }
                        } elseif (date("H:i:s") >= "00:00:00" && date("H:i:s") < "05:59:59") {
                            if ($m['planned_shift_three'] > 0) {
                                $percentm = ceil(($m['completed_shift_three'] / $m['planned_shift_three']) * 100);
                            } else {
                                $percentm = 0;
                            }
                        }

                        if ($percentm >= 99) {
                            $color = "table-success";
                        } elseif ($percentm > 85 && $percentm < 99) {
                            $color = "table-warning";
                        } else {
                            $color = "table-danger";
                        }
                ?>
                        <tr>
                            <td><?php echo $m['site_name'] ?></td>
                            <td><?php echo $m['asset_name'] ?></td>
                            <td class="<?php echo $color ?>">
                                <b>
                                    <?php echo $percentm; ?>
                                    %
                                </b>
                            </td>

                        </tr>
                <?php
                    endforeach;
                }
                ?>
                </tbody>
                </table>
            </div>




            <div class="card">
                <h3 class="text-center mt-5 mb-5">Ensamble</h3>
                <?php
                if (count($ensamble) === 0) {
                    echo '<div style="padding-left:0.8rem; padding-right:0.8rem;">';
                    $this->load->helper('messages');
                    show_alert_noplan(null);
                    echo '</div>';
                } else {
                    echo '
                    <table class="table w-full mt-3 text-center">
                        <thead>
                            <tr>
                                <th class="text-center uppercase">Area</th>
                                <th class="text-center uppercase">Output</th>
                                <th class="text-center uppercase">Shift Status</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    foreach ($ensamble as $e) :
                        if (date("H:i:s") >= "06:00:00" && date("H:i:s") < "16:00:00") {
                            if ($e['planned_shift_one'] > 0) {
                                $percente = ceil(($e['completed_shift_one'] / $e['planned_shift_one']) * 100);
                            } else {
                                $percente = 0;
                            }
                        } elseif (date("H:i:s") >= "16:00:00" && date("H:i:s") < "23:59:59") {
                            if ($e['planned_shift_two'] > 0) {
                                $percente = ceil(($e['completed_shift_two'] / $e['planned_shift_two']) * 100);
                            } else {
                                $percente = 0;
                            }
                        } elseif (date("H:i:s") >= "00:00:00" && date("H:i:s") < "05:59:59") {
                            if ($e['planned_shift_three'] > 0) {
                                $percente = ceil(($e['completed_shift_three'] / $e['planned_shift_three']) * 100);
                            } else {
                                $percente = 0;
                            }
                        }
                        if ($percente >= 99) {
                            $color = "table-success";
                        } elseif ($percente > 85 && $percentm < 99) {
                            $color = "table-warning";
                        } else {
                            $color = "table-danger";
                        }
                ?>
                        <tr>
                            <td><?php echo $e['site_name'] ?></td>
                            <td><?php echo $e['asset_name'] ?></td>
                            <td class="<?php echo $color ?>">
                                <b>
                                    <?php echo $percente ?> %
                                </b>
                            </td>

                        </tr>
                <?php
                    endforeach;
                }
                ?>
                </tbody>
                </table>
            </div>

            <div class="card">
                <h3 class="text-center mt-5 mb-5">Planta 3</h3>
                <?php
                if (count($planta3) === 0) {
                    echo '<div style="padding-left:0.8rem; padding-right:0.8rem;">';
                    $this->load->helper('messages');
                    show_alert_noplan(null);
                    echo '</div>';
                } else {
                    echo '
                    <table class="table w-full mt-3 text-center">
                        <thead>
                            <tr>
                                <th class="text-center uppercase">Area</th>
                                <th class="text-center uppercase">Output</th>
                                <th class="text-center uppercase">Shift Status</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    foreach ($planta3 as $p) :
                        if (date("H:i:s") >= "06:00:00" && date("H:i:s") < "16:00:00") {
                            if ($p['planned_shift_one'] > 0) {
                                $percentp = ceil(($p['completed_shift_one'] / $p['planned_shift_one']) * 100);
                            } else {
                                $percentp = 0;
                            }
                        } elseif (date("H:i:s") >= "16:00:00" && date("H:i:s") < "23:59:59") {
                            if ($p['planned_shift_two'] > 0) {
                                $percentp = ceil(($p['completed_shift_two'] / $p['planned_shift_two']) * 100);
                            } else {
                                $percentp = 0;
                            }
                        } elseif (date("H:i:s") >= "00:00:00" && date("H:i:s") < "05:59:59") {
                            if ($p['planned_shift_three'] > 0) {
                                $percentp = ceil(($p['completed_shift_three'] / $p['planned_shift_three']) * 100);
                            } else {
                                $percentp = 0;
                            }
                        }
                        if ($percentp >= 99) {
                            $color = "table-success";
                        } elseif ($percentp > 85 && $percentp < 99) {
                            $color = "table-warning";
                        } else {
                            $color = "table-danger";
                        }
                ?>
                        <tr>
                            <td><?php echo $p['site_name'] ?></td>
                            <td><?php echo $p['asset_name'] ?></td>
                            <td class="<?php echo $color ?> ">
                                <b>
                                    <?php echo $percentp ?> %
                                </b>
                            </td>

                        </tr>
                <?php
                    endforeach;
                }
                ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo  base_url() ?>assets/js/chart.min.js"></script>
<script>
    function display_ct5() {
        var x = new Date()
        var ampm = x.getHours() >= 12 ? ' PM' : ' AM';

        var x1 = x.getMonth() + 1 + "/" + x.getDate() + "/" + x.getFullYear();
        x1 = x1 + " - " + x.getHours() + ":" + x.getMinutes() + ":" + x.getSeconds() + ":" + ampm;
        document.getElementById('ct5').innerHTML = x1;
        display_c5();
    }

    function display_c5() {
        var refresh = 1000; // Refresh rate in milli seconds
        mytime = setTimeout('display_ct5()', refresh)
    }
    display_c5()
</script>