	<div ng-app='manualCaptureApp' ng-controller='manualCaptureController' id="rootApp">

		<!-- Breadcrumb -->
		<section class="breadcrumb lg:flex items-start">
			<div>
				<h1><?= $title ?> in {{selected_plant.plant_name}}</h1>
				<ul>
					<li><a href="#">Pages</a></li>
					<li class="divider la la-arrow-right"></li>
					<li><?= $title ?></li>
				</ul>
			</div>

			<div class="flex flex-wrap gap-2 items-center ltr:ml-auto rtl:mr-auto mt-5 lg:mt-0">


				<div class="input-group mt-5">
					<div class="input-addon input-addon-prepend input-group-item">Plant</div>
					<select ng-options="plant as plant.plant_name for plant in plants track by plant.plant_id" ng-model="selected_plant"></select>

					<div class="input-addon input-addon-prepend input-group-item">Site</div>
					<select ng-options="site as site.site_name for site in sites track by site.site_id" ng-model="selected_site"></select>

					<button class="btn btn_primary uppercase input-group-item" ng-click="filter_plant_site()">Filter</button>
				</div>

			</div>
		</section>


		<!-- Tabs -->
		<div class="grid lg:grid-cols-1 gap-5">
			<div class="p-5">
				<div class="tabs">

					<nav class="tab-nav mt-5">

						<?php
						foreach ($shifts as $index => $shift) {
							echo '<button class="nav-link h5 uppercase' . (($index == 0) ? ' active' : ' ')  . '" data-toggle="tab" data-target="#tab-' . $shift['shift_id']  . '">';
							echo '<span class="las ' . $shift['icon'] . '"></span>';
							echo $shift['shift_name'];
							echo '</button>';
						}

						?>

					</nav>


					<div class="tab-content mt-5">

						<?php
						$current = new DateTime();

						foreach ($shifts as $index => $shift) {
							echo '<div id="tab-' . $shift['shift_id'] . '" class="collapse' . (($index == 0) ? ' open' : ' ') . '">';


							if (count($shift['assets']) == 0) {
								echo '<div class="alert alert_primary">
								<strong class="uppercase"><bdi>Info!</bdi></strong>
								This turn does not have plan production for any machine or workstation
								</div>';
							}


							//One table by asset
							foreach ($shift['assets'] as $asset) {
								echo '<table class="table w-full mt-3">';

								$production_plan = $asset['production_plan'];
								echo '<table class="table w-full mt-3">';

								$current_item_number = 'N/A';
								//THEAD	
								echo '<thead><tr>';
								echo '<th >Estación</th>';
								foreach ($production_plan['plan_by_hours'] as $plan_by_hour) {
									$start = new DateTime($plan_by_hour['time']);
									$end = new DateTime($plan_by_hour['time_end']);

									if ($current >= $start && $current < $end) {
										if (isset($plan_by_hour['item_number']))
											$current_item_number = $plan_by_hour['item_number'];
										else
											$current_item_number = 'N/A';
										//"background-color", "#BAE6FD"
										echo '<th id="th_2" style="background-color: #BAE6FD;">' . date(HOUR_MINUTE_FORMAT, strtotime($plan_by_hour['time'])) . '</th>';
									} else {
										echo '<th id="th_2">' . date(HOUR_MINUTE_FORMAT, strtotime($plan_by_hour['time'])) . '</th>';
									}
								}
								echo '</tr></thead>';

								//TBODY
								echo '<tbody class="text-center">';
								echo '<tr>';

								echo '<td>';
								echo '    <div>';
								echo '       <p>' . $asset['asset_name'] . '</p>';
								echo '       <p>' . $asset['site_name'] . '</p>';
								echo '       <p>' . $current_item_number . '</p>';
								echo '    </div>';
								echo '</td>';


								foreach ($production_plan['plan_by_hours'] as $plan_by_hour) {
									$is_enable = isset($plan_by_hour['item_number']);

									echo '<td>';
									echo ' <p>' . ($is_enable ? $plan_by_hour['item_number'] : 'N/A')  . '</p>';
									echo '<input type="number" name="plant_id" value="' . $plant_id . '" hidden/>';
									echo '	<input class="form-control" type="number" id="input_plan_by_hour_id_' . $plan_by_hour['plan_by_hour_id'] . '" value="' . $plan_by_hour['completed'] . '" style="min-width: 8rem;" ' . ($is_enable ? '' : 'disabled') . ' onchange="input_change(' . $plan_by_hour['plan_by_hour_id'] . ')" />';

									//echo '<p>' . $plan_by_hour['completed'] . '/' . $plan_by_hour['plan_by_hour_id'] . '<p/>';
									if ($plan_by_hour['planned'] == null)
										echo '<div>  <span id="span_completed_plan_by_hour_id_' . $plan_by_hour['plan_by_hour_id'] . '">N/A</span> </div>';
									else
										echo '<div>  <span id="span_completed_plan_by_hour_id_' . $plan_by_hour['plan_by_hour_id'] . '">' . $plan_by_hour['completed'] . '</span><span>/</span><span>' . $plan_by_hour['planned'] . '</span> </div>';

									//echo '	<button id="button_plan_by_hour_id_' . $plan_by_hour['plan_by_hour_id'] . '" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase" ' . ($is_enable ? '' : 'disabled') . ' ng-click="save(' . $plan_by_hour['plan_by_hour_id'] . ')">';
									//echo '		<span id="span_plan_by_hour_id_' . $plan_by_hour['plan_by_hour_id'] . '" class="la la-save"></span>';
									//echo '	</button>';

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


	</div>

	<script>
		function input_change(id) {
			//console.log(id);

			//var scope = angular.element(document.getElementById('rootApp')).scope();
			//scope.save(1);
			//console.log(scope);
			//angular.element(document.getElementById('rootApp')).injector().get('$rootScope').$save(id);

			var scope = angular.element(document.getElementById('rootApp')).scope();
			scope.$apply(function() {
				scope.save(id);
			})
		}

		/*
		 * Author: Emanuel Jauregui
		 * Date: 04/04/2022  
		 * This angular code is for fill selects
		 * 
		 */
		var fetch = angular.module('manualCaptureApp', []);
		fetch.controller('manualCaptureController', ['$scope', '$http', '$httpParamSerializerJQLike', function($scope, $http, $httpParamSerializerJQLike) {

			$scope.plants = null;
			$scope.selected_plant = null;

			$scope.sites = null;
			$scope.selected_site = null;

			$scope.init = function(plant_id, site_id) {
				console.log('init plant_id ' + plant_id);
				$scope.getPlants(plant_id, site_id);
			}

			$scope.getPlants = function(plant_id = null, site_id = null) {
				$http({
					method: 'get',
					url: '<?= base_url() ?>index.php/api/plants/all',
				}).then(function successCallback(response) {

					$scope.plants = response.data;

					if (plant_id != null) {
						//Se deben convertir a Number porque el api regresa strings...
						var plant = $scope.plants.filter(function(plant) {
							return Number(plant.plant_id) === Number(plant_id);
						})[0];
						$scope.selected_plant = plant;
						$scope.getSites(site_id);
					}
				});
			}

			$scope.getSites = function(site_id = null) {
				$http({
					method: 'get',
					url: '<?= base_url() ?>index.php/api/sites/all/' + $scope.selected_plant.plant_id
				}).then(function successCallback(response) {

					// Assign response to users object
					$scope.sites = response.data;
					console.log($scope.plants);
					$scope.sites.unshift({
						site_name: 'All Sites',
						site_id: -1
					});

					if (site_id != null) {
						var site = $scope.sites.filter(function(site) {
							return Number(site.site_id) === Number(site_id);
						})[0];
						$scope.selected_site = site;
					} else {
						var site = $scope.sites.filter(function(site) {
							return Number(site.site_id) === -1;
						})[0];
						$scope.selected_site = site;
					}

				});
			}


			$scope.filter_plant_site = function() {
				var url = '<?php echo base_url() ?>manual_capture?';
				url += 'plant_id=' + $scope.selected_plant.plant_id;
				if ($scope.selected_site != undefined)
					url += '&site_id=' + $scope.selected_site.site_id;
				window.open(url, "_self")
			}


			$scope.save = function(plan_by_hour_id) {

				var inputIdString = 'input_plan_by_hour_id_' + plan_by_hour_id;
				var value = document.getElementById(inputIdString).value;

				value = Math.abs(value);
				document.getElementById(inputIdString).value = value;

				var data = {
					"value": value,
					"plan_by_hour_id": plan_by_hour_id,
					"reset": 1,
					"capture_type": <?= CAPTURE_MANUAL ?>
				};

				$http({
					url: '<?= base_url() ?>api/manual_capture/modify',
					method: 'POST',
					data: $httpParamSerializerJQLike(data), // Make sure to inject the service you choose to the controller
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded' // Note the appropriate header
					}
				}).then(function(response) {
					console.log(response);
				});
			}


			$scope.init(<?= $plant_id ?>, <?= $site_id ?>);

		}]);
	</script>