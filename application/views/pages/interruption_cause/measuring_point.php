 <section class="breadcrumb">
     <h1><?= $title ?></h1>
     <ul>
         <li><a href="<?php echo base_url(); ?>/manual_capture/select_plant_button">Selecciona planta</a></li>
         <li class="divider la la-arrow-right"></li>
         <li><?= $title ?></li>
     </ul>
     <div class="grid lg:grid-cols-4 gap-5 p-5">
         <?php
            foreach ($item_by_plan as $item) {
                if($item['plan_id'] != null){
                    echo '<a href="' . base_url() . '/interruption_cause/index?asset_id=' . $item['asset_id'] . '">';
                }else{
                    echo '<a href="#"';
                    echo 'style="cursor: no-drop; color: gray;" >';
                }
                echo '<div class="card p-5">';
                echo '<div class="items-center px-5 py-2">';
                echo '<h5 class="mb-0 uppercase">' . $item['asset_name'] . '</h5>';
                echo '<small>Selecciona este punto</small>';

                if ($item['plan_id'] != NULL) {
                    echo '<small class="text-primary"><span class="icon las la-exclamation-triangle mt-3"></span>Ya se encuentra cargado un plan para este diay</small>';
                }
                echo '</div>';
                echo '</div>';
                echo '</a>';
            }
            ?>
     </div>
 </section>