<section>
    <h1><?= $title ?></h1>
    <div class="grid lg:grid-cols-4 gap-5 p-5">
        <?php
        foreach ($plants as $plant) {
            $assets = $plant['sites'];
            echo '     <div class="card p-5">';
            echo '
                <div class="items-center px-5 py-2">
                    <h5 class="mb-0 uppercase"> ' . $plant['plant_name'] . '</h5>
                    <small>Selet a cell</small>
                </div>
                <hr>';
            foreach ($assets as $asset) {
                echo ' <table class="table table_list mt-3 w-full">
                    <thead>
                        <tr> ';
                echo '
                            <th class="ltr:text-left rtl:text-right uppercase">';
                if (intval($asset['assets_count']) <= 0) {
                    echo '<a href="#" ';
                } else {
                    echo '<a href="' . base_url() . 'output_vs_plan/add_monitor" ';
                    //echo '<a href="' . base_url() . 'output_vs_plan/add_monitor?site_id=' . $asset['site_id'] . '&plant_id=' . $asset['plant_id'] . '" ';
                }
                if (intval($asset['assets_count']) <= 0) echo 'style="cursor: no-drop; color: gray;"';
                echo '>' . $asset['site_name'];
                echo '    
                            <th class="w-px uppercase">
                            <div class="badge badge_warning uppercase">' . $asset['assets_count'] . '</div>
                            </th>
                        </tr>
                    </thead>
                    </table>
                ';
            }
            echo '</div>';
        }
        ?>
    </div>
</section>