 <!-- Brand -->
 <span class="brand" style="margin-top: -6.5rem;">
     <img width="150" src="<?php echo base_url(); ?>assets/images/transparente.png" alt="">
 </span>
 <!-- Breadcrumb -->
 <section class="breadcrumb">
     <h1><?= $title ?></h1>
     <ul>
         <li class="divider la la-arrow-right"></li>
         <li><?= $title ?></li>
     </ul>
     <div class="grid lg:grid-cols-4 gap-5 p-5">
         <?php
            foreach ($plants as $plant) {
                $assets = $plant['sites'];
                echo '     <div class="card p-5">';
                echo '
                <div class="items-center px-5 py-2">
                    <h5 class="mb-0 uppercase"> ' . $plant['plant_name'] . '</h5>
                    <small>Selecciona una Celda</small>
                </div>
                <hr>';
                foreach($assets as $asset) {   
                    echo ' <table class="table table_list mt-3 w-full">
                    <thead>
                        <tr> ';
                    echo '
                            <th class="ltr:text-left rtl:text-right uppercase">';
                    if (intval($asset['assets_count']) <= 0) {
                        echo '<a href="#" ';
                    } else {
                        echo '<a href="' . base_url() . 'manual_capture/measuring_point?site_id=' . $asset['site_id'] .'&plant_id=' . $asset['plant_id'] . '" ';
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