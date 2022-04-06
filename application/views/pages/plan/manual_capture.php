	<!-- Breadcrumb -->
	<section class="breadcrumb">
	    <h1><?= $title ?></h1>
	    <ul>
	        <li><a href="#">Pages</a></li>
	        <li class="divider la la-arrow-right"></li>
	        <li><?= $title ?></li>
	    </ul>
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

					 <!--
					<button class="nav-link h5 uppercase active" data-toggle="tab" data-target="#tab-1">
                    <span class="las la-sun"></span>
	                    Shift One
					</button>
	                
					<button class="nav-link h5 uppercase mr-5" data-toggle="tab" data-target="#tab-2">
                    <span class="las la-cloud-moon"></span>
	                    Shift Two
					</button>
	                
					<button class="nav-link h5 uppercase" data-toggle="tab" data-target="#tab-3">
                    <span class="las la-moon"></span>
	                    Shift Three
					</button>
					-->
	            </nav>

	            <!-- Shift one -->

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


					<!--
	                <div id="tab-1" class="collapse open">
	                    <table class="table w-full mt-3">
	                        <thead>
	                            <tr>
	                                <th>Estación</th>
	                                <th id="th_2">06:00am</th>
	                                <th id="th_3">07:00am</th>
	                                <th id="th_4">08:00am</th>
	                                <th id="th_5">09:00am</th>
	                                <th id="th_6">10:00am</th>
	                                <th id="th_7">11:00am</th>
	                                <th id="th_8">12:00pm</th>
	                                <th id="th_9">13:00pm</th>
	                                <th id="th_10">14:00pm</th>
	                                <th id="th_11">15:00pm</th>
	                            </tr>
	                        </thead>
	                        <tbody class="text-center">
	                            <tr>
	                                <td>
	                                    <div>
	                                        <p>TIP32</p>
	                                        <p>AC1004HFC</p>
	                                    </div>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                            </tr>
	                        </tbody>
	                    </table>

	                </div>
					-->
				

	                <!-- Shift two -->

					<!--
	                <div id="tab-2" class="collapse">
	                    <table class="table w-full mt-3">
	                        <thead>
	                            <tr>
	                                <th>Estación</th>
	                                <th id="th_12">16:00pm</th>
	                                <th id="th_13">17:00pm</th>
	                                <th id="th_14">18:00pm</th>
	                                <th id="th_15">19:00pm</th>
	                                <th id="th_16">20:00pm</th>
	                                <th id="th_17">21:00pm</th>
	                                <th id="th_18">22:00pm</th>
	                                <th id="th_19">23:00pm</th>
	                            </tr>
	                        </thead>
	                        <tbody class="text-center">
	                            <tr>
	                                <td>
	                                    <div>
	                                        <p>TIP32</p>
	                                        <p>AC1004HFC</p>
	                                    </div>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>
	                                </td>
	                            </tr>
	                        </tbody>
	                    </table>
	                </div>
					-->


	                <!-- Shift three -->
					<!--
	                <div id="tab-3" class="collapse">
	                    <table class="table w-full mt-3">
	                        <thead>
	                            <tr>
	                                <th>Estación</th>
	                                <th id="th_20">00:00am</th>
	                                <th id="th_21">01:00am</th>
	                                <th id="th_22">02:00am</th>
	                                <th id="th_23">03:00am</th>
	                                <th id="th_24">04:00am</th>
	                                <th id="th_25">05:00am</th>
	                            </tr>
	                        </thead>
	                        <tbody class="text-center">
	                            <tr>
	                                <td>
	                                    <div>
	                                        <p>TIP32</p>
	                                        <p>AC1004HFC</p>
	                                    </div>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>
	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>

	                                </td>
	                                <td>
	                                    <input class="form-control" type="number" value="0" style="min-width: 8rem;" />
	                                    <button type="button" class="btn mt-4 btn-icon btn-icon_large btn_success uppercase">
	                                        <span class="la la-save"></span>
	                                    </button>
	                                </td>
	                            </tr>
	                        </tbody>
	                    </table>
	                </div>
					-->

	            </div>
	        </div>
	    </div>
	</div>

	<script>
	    window.onload = function() {
	        var d = new Date();
	        var h = d.getHours();
	        if (h === 6) {
	            $('#th_2').css("background-color", "#BAE6FD");
	        }
	        if (h === 7) {
	            $('#th_3').css("background-color", "#BAE6FD");
	        }
	        if (h === 8) {
	            $('#th_4').css("background-color", "#BAE6FD");
	        }
	        if (h === 9) {
	            $('#th_5').css("background-color", "#BAE6FD");
	        }
	        if (h === 10) {
	            $('#th_6').css("background-color", "#BAE6FD");
	        }
	        if (h === 11) {
	            $('#th_7').css("background-color", "#BAE6FD");
	        }
	        if (h === 12) {
	            $('#th_8').css("background-color", "#BAE6FD");
	        }
	        if (h === 13) {
	            $('#th_9').css("background-color", "#BAE6FD");
	        }
	        if (h === 14) {
	            $('#th_10').css("background-color", "#BAE6FD");
	        }
	        if (h === 15) {
	            $('#th_11').css("background-color", "#BAE6FD");
	        }
	        if (h === 16) {
	            $('#th_12').css("background-color", "#BAE6FD");
	        }
	        if (h === 17) {
	            $('#th_13').css("background-color", "#BAE6FD");
	        }
	        if (h === 18) {
	            $('#th_14').css("background-color", "#BAE6FD");
	        }
	        if (h === 19) {
	            $('#th_15').css("background-color", "#BAE6FD");
	        }
	        if (h === 20) {
	            $('#th_16').css("background-color", "#BAE6FD");
	        }
	        if (h === 21) {
	            $('#th_17').css("background-color", "#BAE6FD");
	        }
	        if (h === 22) {
	            $('#th_18').css("background-color", "#BAE6FD");
	        }
	        if (h === 23) {
	            $('#th_19').css("background-color", "#BAE6FD");
	        }
	        if (h === 0) {
	            $('#th_20').css("background-color", "#BAE6FD");
	        }
	        if (h === 1) {
	            $('#th_21').css("background-color", "#BAE6FD");
	        }
	        if (h === 2) {
	            $('#th_22').css("background-color", "#BAE6FD");
	        }
	        if (h === 3) {
	            $('#th_23').css("background-color", "#BAE6FD");
	        }
	        if (h === 4) {
	            $('#th_24').css("background-color", "#BAE6FD");
	        }
	        if (h === 5) {
	            $('#th_25').css("background-color", "#BAE6FD");
	        }
	    };
	</script>