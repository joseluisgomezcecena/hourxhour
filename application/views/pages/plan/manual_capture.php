	<!-- Breadcrumb -->
	<section class="breadcrumb lg:flex items-start" ng-app='manualCaptureApp' >
		<div>
			<h1><?= $title ?></h1>
			<ul>
				<li><a href="#">Pages</a></li>
				<li class="divider la la-arrow-right"></li>
				<li><?= $title ?></li>
			</ul>
		</div>
	   
		<div class="flex flex-wrap gap-2 items-center ltr:ml-auto rtl:mr-auto mt-5 lg:mt-0">


		
		<div class="input-group mt-5" ng-controller='filterController'>
                        <div class="input-addon input-addon-prepend input-group-item">Plant</div>
                        
						<select ng-options="plant as item.label for plant in plants track by plant.plant_id" ng-model="selected"></select>

						<!--
						<select type="text"  class="form-control input-group-item" style="width: 10rem;" placeholder="First name">
							<option>All Plants</option>
						</select>
						-->

						<div class="input-addon input-addon-prepend input-group-item">Site</div>
                        
						<select type="text" class="form-control input-group-item"  style="width: 10rem;" placeholder="Last name">
							<option>All Sites</option>
						</select>
						
						<button class="btn btn_primary uppercase input-group-item">Filter</button>
                    </div>
		              
        </div>
		

	</section>
	<!-- Tabs -->
	<div class="grid lg:grid-cols-1 gap-5">
	    <div class="p-5">
	        <div class="tabs">

	            <nav class="tab-nav mt-5">
	                
					<?php

						foreach($shifts as $index => $shift)
						{
							echo '<button class="nav-link h5 uppercase' . (($index == 0) ? ' active' : ' ')  . '" data-toggle="tab" data-target="#tab-' . $shift['shift_id']  .'">';
							echo '<span class="las ' . $shift['icon'] .'"></span>';
							echo $shift['shift_name'];
							echo '</button>';
						}
					?>

	            </nav>


	            <div class="tab-content mt-5">

				<?php
				$current = new DateTime();

				foreach($shifts as $index => $shift)
				{
					echo '<div id="tab-' . $shift['shift_id'] . '" class="collapse' . (($index == 0) ? ' open' : ' ') . '">';
					
					
					//One table by asset
					foreach($shift['assets'] as $asset)
					{
						echo '<table class="table w-full mt-3">';

						$production_plan = $asset['production_plan'];
						echo '<table class="table w-full mt-3">';

						$current_item_number = 'N/A';
						//THEAD	
						echo '<thead><tr>';
						echo '<th >Estación</th>';
						foreach( $production_plan->plan_by_hours as $plan_by_hour )
						{		
							$start = new DateTime( $plan_by_hour['time'] );
							$end = new DateTime( $plan_by_hour['time_end'] );

							if($current >= $start && $current < $end )
							{
								if(isset($plan_by_hour['item_number']))
									$current_item_number = $plan_by_hour['item_number'];
								else
									$current_item_number = 'N/A';
								//"background-color", "#BAE6FD"
								echo '<th id="th_2" style="background-color: #BAE6FD;">' . date( HOUR_MINUTE_FORMAT, strtotime( $plan_by_hour['time'] ) ) . '</th>';
							} else
							{
								echo '<th id="th_2">' . date( HOUR_MINUTE_FORMAT, strtotime( $plan_by_hour['time'] ) ) . '</th>';
							}						
						}
						echo '</tr></thead>';

						//TBODY
						echo '<tbody class="text-center">';
						echo '<tr>';

						echo '<td>';
	                    echo '    <div>';
	                    echo '       <p>' . $asset['asset_name'] . '</p>';
	                    echo '       <p>' . $asset['site_name'] .'</p>';
	                    echo '       <p>' . $current_item_number .'</p>';
	                    echo '    </div>';
	                	echo '</td>';

					
						foreach( $production_plan->plan_by_hours as $plan_by_hour )
						{				
							$is_enable = isset($plan_by_hour['item_number']);
							
							echo '<td>';
							echo ' <p>' . ( $is_enable ? $plan_by_hour['item_number'] : 'N/A')  .'</p>';

							echo '<form action="' . base_url() . 'manual_capture/save" method="post">';
							echo '<input type="number" name="plant_id" value="' . $plant_id . '" hidden/>';
							echo '	<input class="form-control" type="number" name="plan_by_hour_id_' . $plan_by_hour['plan_by_hour_id'] . '" value="' . $plan_by_hour['completed'] . '" style="min-width: 8rem;" ' . ($is_enable ? '' : 'disabled') . '/>';
							echo '	<button type="submit" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase" ' . ($is_enable ? '' : 'disabled') . '>';
							echo '		<span class="la la-save"></span>';
							echo '	</button>';
							echo '</form>';	
							echo '</td>';
						}
						
						echo '</tr>';
						echo '</tbody>';

						echo '</table>';

						echo '<hr style="border-top: 1px solid #bbb;">';
						
					}

				

					echo '</div>';
				}

				?>

	            </div>
	        </div>
	    </div>
	</div>


	<script>
    /*
     * Author: Emanuel Jauregui
     * Date: 04/04/2022  
     * This angular code is for fill selects
     * 
     */
    var fetch = angular.module('manualCaptureApp', []);
    fetch.controller('filterController', ['$scope', '$http', function($scope, $http) {

			$scope.plants = null;

			$scope.init = function(){
				console.log('init');

				$scope.getPlants();
			}

			$scope.getPlants = function(){
				$http({
                method: 'get',
                url: '<?= base_url() ?>index.php/api/plants/all',
				}).then(function successCallback(response) {
					
					$scope.plants = response.data;
					console.log($scope.plants);
				});
			}


			$scope.init();

	}]);

	
	</script>