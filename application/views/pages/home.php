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

        <div class="grid sm:grid-cols-3 gap-5 my-5">

            <?php
            foreach ($plants as $plant) {

                echo '<div class="card">';
                echo '<h3 class="text-center mt-5 mb-5">' . $plant['plant_name'] . '</h3>';

                if (count($plant['data']) === 0) {
                    echo '<div style="padding-left:0.8rem; padding-right:0.8rem; margin-bottom: 2rem;">';
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

                    foreach ($plant['data'] as $item) {

                        //echo json_encode($item);
                        $percent = 0;

                        if ($item['completed'] > 0)
                            $percent = ceil(($item['completed'] / $item['planned']) * 100);

                        if ($percent >= 99) {
                            $color = "table-success";
                        } elseif ($percent > 85 && $percent < 99) {
                            $color = "table-warning";
                        } else {
                            $color = "table-danger";
                        }

                        echo '<tr>';
                        echo '<td>' . $item['site_name'] . '</td>';
                        echo '<td>'  . $item['asset_name'] . '</td>';
                        echo '<td class="' . $color . '">';
                        echo '    <b>' . $percent .  '%</b>';
                        echo '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody>
                           </table> ';
                }

                echo '</div>';
            }
            ?>

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