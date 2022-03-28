	<!-- Breadcrumb -->
	<section class="breadcrumb">
	    <h1><?= $title ?></h1>
		

	    <ul>
	        <li><a href= "<?php echo base_url(); ?>index.php" >Pages</a></li>
	        <li class="divider la la-arrow-right"></li>
	        <li> <a >Select a Cell</a></li>
	    </ul>
	    
		<div class="grid lg:grid-cols-4 gap-5 p-5">
	        <div class="card p-5">
	            <div class="items-center px-5 py-2">
	                <h5 class="mb-0 uppercase"><?php echo $plant->plant_name ?></h5>
	                <small>Selet a cell</small>
	            </div>
	            <hr>

	            <table class="table table_list mt-3 w-full">
	                <thead>
						<?php

						foreach($sites as $site)
						{
							//echo $site['site_name'];

							echo '<tr>';
							echo '<th class="ltr:text-left rtl:text-right uppercase">';
							echo '<a href="' . base_url() . 'index.php/measuring_point?site_id=' . $site['site_id'] .'&plant_id=' . $site['plant_id'] . '"';
							if( intval($site['assets_count']) <= 0 ) echo 'style="cursor: no-drop;"';
							echo '>' . $site['site_name'];

							echo '</a>';
							echo '</th>';
							
							echo '<th class="w-px uppercase">';
							echo '<div class="badge badge_warning uppercase">' . $site['assets_count'] .'</div>';
							echo '</th>';
							
							echo '<th>';
						}
						?>

	                </thead>
	            </table>


	        </div>
	    </div>
	</section>