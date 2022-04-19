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
        <!-- Summaries -->
        <div class="grid sm:grid-cols-3 gap-5 my-5">

			<div class="card">
				<h3 class="text-center mt-5 mb-5">Moldeo</h3>
				<table class="table w-full mt-3 text-center">
					<thead>
					<tr>
						<th class="text-center uppercase">Area</th>
						<th class="text-center uppercase">Output</th>
						<th class="text-cente uppercaser">Shift Status</th>
					</tr>
					</thead>
					<tbody>
					<?php
					//print_r($moldeo);
					foreach ($moldeo as $m) :

					?>
					<tr>
						<td><?php echo $m['site_name'] ?></td>
						<td><?php echo $m['asset_name'] ?></td>
						<td class="table-warning">
							<b>
							<?php

							if(date("H:i:s") >= "06:00:00" && date("H:i:s") < "16:00:00" )
							{
								if($m['planned_shift_one'] > 0)
								{
									echo ceil(($m['completed_shift_one']/$m['planned_shift_one']) * 100);
								}
								else
								{
									echo "0";
								}
							}
							elseif(date("H:i:s") >= "16:00:00" && date("H:i:s") < "23:59:59" )
							{
								if($m['planned_shift_two'] > 0)
								{
									echo ceil(($m['completed_shift_two']/$m['planned_shift_two']) * 100);
								}
								else
								{
									echo "0";
								}
							}
							elseif(date("H:i:s") >= "00:00:00" && date("H:i:s") < "05:59:59" )
							{
								if($m['planned_shift_three'] > 0)
								{
									echo ceil(($m['completed_shift_three']/$m['planned_shift_three']) * 100);
								}
								else
								{
									echo "0";
								}
							}
							?>
								%
							</b>
						</td>

					</tr>
					<?php
					endforeach;
					?>
					</tbody>
				</table>
			</div>




			<div class="card">
				<h3 class="text-center mt-5 mb-5">Ensamble</h3>
				<table class="table w-full mt-3 text-center">
					<thead>
					<tr>
						<th class="text-center uppercase">Area</th>
						<th class="text-center uppercase">Output</th>
						<th class="text-cente uppercaser">Shift Status</th>
					</tr>
					</thead>
					<tbody>
					<?php
					//print_r($moldeo);
					foreach ($ensamble as $e) :

						?>
						<tr>
							<td><?php echo $e['site_name'] ?></td>
							<td><?php echo $e['asset_name'] ?></td>
							<td class="table-warning">
								<b>
									<?php

									if(date("H:i:s") >= "06:00:00" && date("H:i:s") < "16:00:00" )
									{
										if($e['planned_shift_one'] > 0)
										{
											echo ceil(($e['completed_shift_one']/$e['planned_shift_one']) * 100);
										}
										else
										{
											echo "0";
										}
									}
									elseif(date("H:i:s") >= "16:00:00" && date("H:i:s") < "23:59:59" )
									{
										if($e['planned_shift_two'] > 0)
										{
											echo ceil(($e['completed_shift_two']/$e['planned_shift_two']) * 100);
										}
										else
										{
											echo "0";
										}
									}
									elseif(date("H:i:s") >= "00:00:00" && date("H:i:s") < "05:59:59" )
									{
										if($e['planned_shift_three'] > 0)
										{
											echo ceil(($e['completed_shift_three']/$e['planned_shift_three']) * 100);
										}
										else
										{
											echo "0";
										}
									}
									?>
									%
								</b>
							</td>

						</tr>
					<?php
					endforeach;
					?>
					</tbody>
				</table>
			</div>




			<div class="card">
				<h3 class="text-center mt-5 mb-5">Planta 3</h3>
				<table class="table w-full mt-3 text-center">
					<thead>
					<tr>
						<th class="text-center uppercase">Area</th>
						<th class="text-center uppercase">Output</th>
						<th class="text-cente uppercaser">Shift Status</th>
					</tr>
					</thead>
					<tbody>
					<?php
					//print_r($moldeo);
					foreach ($planta3 as $p) :

						?>
						<tr>
							<td><?php echo $p['site_name'] ?></td>
							<td><?php echo $p['asset_name'] ?></td>
							<td class="table-warning">
								<b>
									<?php

									if(date("H:i:s") >= "06:00:00" && date("H:i:s") < "16:00:00" )
									{
										if($p['planned_shift_one'] > 0)
										{
											echo ceil(($p['completed_shift_one']/$p['planned_shift_one']) * 100);
										}
										else
										{
											echo "0";
										}
									}
									elseif(date("H:i:s") >= "16:00:00" && date("H:i:s") < "23:59:59" )
									{
										if($p['planned_shift_two'] > 0)
										{
											echo ceil(($p['completed_shift_two']/$p['planned_shift_two']) * 100);
										}
										else
										{
											echo "0";
										}
									}
									elseif(date("H:i:s") >= "00:00:00" && date("H:i:s") < "05:59:59" )
									{
										if($p['planned_shift_three'] > 0)
										{
											echo ceil(($p['completed_shift_three']/$p['planned_shift_three']) * 100);
										}
										else
										{
											echo "0";
										}
									}
									?>
									%
								</b>
							</td>

						</tr>
					<?php
					endforeach;
					?>
					</tbody>
				</table>
			</div>


			<!--

			<h3 class="text-center mt-5 mb-5">Moldeo</h3>
			<table class="table w-full mt-3 text-center">
				<thead>
					<tr>
						<th class="text-center uppercase">Area</th>
						<th class="text-center uppercase">Output</th>
						<th class="text-cente uppercaser">Shift Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>DILATORS</td>
						<td>Packing</td>
						<td class="table-warning"><b>86%</b></td>

					</tr>
					<tr>
						<td>SHORT TERM</td>
						<td>TIP Y</td>
						<td class="table-success"><b>99%</b></td>
					</tr>
					<tr>
						<td>GYRUS</td>
						<td>BOY X</td>
						<td class="table-danger"><b>84%</b></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="card">
			<h3 class="text-center mt-5 mb-5">Ensamble</h3>
			<table class="table w-full mt-3 text-center">
				<thead>
					<tr>
						<th class="text-center uppercase">Area</th>
						<th class="text-center uppercase">Output</th>
						<th class="text-center uppercase">Shift Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>DILATORS</td>
						<td>Packing</td>
						<td class="table-warning"><b>86%</b></td>

					</tr>
					<tr>
						<td>SHORT TERM</td>
						<td>TIP Y</td>
						<td class="table-success"><b>99%</b></td>
					</tr>
					<tr>
						<td>GYRUS</td>
						<td>BOY X</td>
						<td class="table-danger"><b>84%</b></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="card">
			<h3 class="text-center mt-5 mb-5">Planta 3</h3>
			<table class="table w-full mt-3 text-center">
				<thead>
					<tr>
						<th class="text-center uppercase">Area</th>
						<th class="text-center uppercase">Output</th>
						<th class="text-center uppercase">Shift Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>DILATORS</td>
						<td>Packing</td>
						<td class="table-warning"><b>86%</b></td>

					</tr>
					<tr>
						<td>SHORT TERM</td>
						<td>TIP Y</td>
						<td class="table-success"><b>99%</b></td>
					</tr>
					<tr>
						<td>GYRUS</td>
						<td>BOY X</td>
						<td class="table-danger"><b>84%</b></td>
					</tr>
				</tbody>
			</table>
		</div>
		-->
        </div>
    </div>
</section>
<script src="<?php echo  base_url() ?>assets/js/chart.min.js"></script>
<script>

function display_ct5() {
var x = new Date()
var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';

var x1=x.getMonth() + 1+ "/" + x.getDate() + "/" + x.getFullYear(); 
x1 = x1 + " - " +  x.getHours( )+ ":" +  x.getMinutes() + ":" +  x.getSeconds() + ":" + ampm;
document.getElementById('ct5').innerHTML = x1;
display_c5();
 }
 function display_c5(){
var refresh=1000; // Refresh rate in milli seconds
mytime=setTimeout('display_ct5()',refresh)
}
display_c5()
</script>
