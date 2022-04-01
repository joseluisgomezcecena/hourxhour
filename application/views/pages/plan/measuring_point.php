	<!-- Breadcrumb -->
	<section class="breadcrumb">
	    <h1><?= $title ?></h1>
	    <ul>
			<ul>
				<li><a href= "<?php echo base_url(); ?>index.php" >Pages</a></li>
				<li class="divider la la-arrow-right"></li>
				<li> <a href= "<?php echo base_url(); ?>index.php/cell?plant_id=<?php echo $plant_id; ?>" >Select a Cell</a></li>
				<li class="divider la la-arrow-right"></li>
				<li> <a >Measuting Point</a></li>
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
					echo '<small>Selet this point</small>';

					if( $plan['plan_id'] != NULL )
					{
						echo '<small class="text-primary"><span class="icon las la-exclamation-triangle mt-3"></span> There is already a plan for this day</small>';
					}					

					echo '</div>';
					echo '</div>';
					echo '</a>';
				}
			?>
	    </div>
	</section>