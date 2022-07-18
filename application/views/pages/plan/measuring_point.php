	<!-- Breadcrumb -->
	<section class="breadcrumb">
	    <h1><?= $title ?></h1>
	    <ul>
			<ul>
				<li><a href= "<?php echo base_url(); ?>index.php" >Inicio</a></li>
				<li class="divider la la-arrow-right"></li>
				<li> <a href= "<?php echo base_url(); ?>index.php/cell?plant_id=<?php echo $plant_id; ?>" >Selecciona una celda</a></li>
				<li class="divider la la-arrow-right"></li>
				<li> <a >Punto de medición</a></li>
			</ul>


	    </ul>
	    <div class="grid lg:grid-cols-4 gap-5 p-5">


			<?php 

				foreach($production_plans as $plan)
				{
					echo '<a href="' . base_url() . 'index.php/planners?asset_id=' . $plan['asset_id'] .'">';
					echo '<div class="card p-5">';
					echo '<div class="items-center px-5 py-2">';
					echo '<h5 class="mb-0 uppercase">' . $plan['asset_name'] . '</h5>';
                    echo '<small>Selecciona este punto</small>';

					if( $plan['plan_id'] != NULL )
					{
						echo '<small class="text-primary"><span class="icon las la-exclamation-triangle mt-3"></span>Ya se encuentra cargado un plan para este dia</small>';
					}					

					echo '</div>';
					echo '</div>';
					echo '</a>';
				}
			?>
	    </div>
	</section>