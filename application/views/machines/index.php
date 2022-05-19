<!-- Breadcrumb -->
<section class="breadcrumb">
	<h1><?= $title ?></h1>
	<ul>
		<li><a href="#">Pages</a></li>
		<li class="divider la la-arrow-right"></li>
		<li><?= $title ?></li>
	</ul>
</section>

<div class="flex flex-wrap gap-2 items-center ltr:ml-auto rtl:mr-auto mt-5 lg:mt-0">

	<div class="flex gap-x-2 mb-5">
		<!-- Add New -->
		<a href="<?php echo base_url() ?>machines/create" class="btn btn_primary uppercase">Add New</a>
	</div>
</div>

<div class="grid lg:grid-cols-1 gap-5">

	<!-- Content -->
	<div class="lg:col-span-3 xl:col-span-3">
		<div class="card p-5">

			<div class="mt-5">
				<table id="asset-table" class="table table-auto table_hoverable w-full mb-5">
					<thead>
						<tr>
							<th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Plant</th>
							<th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Site</th>
							<th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Asset</th>
							<th style="font-size: 14px !important; width: 150px;" class="ltr:text-center rtl:text-right uppercase">Work Center</th>
							<th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Control Number</th>
							<th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Point Of Measure</th>
							<th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">View</th>
							<th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Edit</th>
							<th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Delete</th>
						</tr>
					</thead>


					<tbody>
						<?php foreach ($machines as $machine) : ?>
							<tr>
								<td class="text-center"><?php echo $machine['plant_name'] ?></td>
								<td class="text-center"><?php echo $machine['site_name'] ?></td>
								<td class="text-center"><?php echo $machine['asset_name'] ?></td>
								<td class="text-center"><?php echo $machine['asset_work_center'] ?></td>
								<td class="text-center"><?php echo $machine['asset_control_number'] ?></td>
								<td class="text-center"><?php echo ($machine['asset_is_pom'] == 1) ? "Yes" : "No"; ?></td>
								<td class="text-center">
									<a href="machines/<?php echo  $machine['asset_id']; ?>" class="btn btn_primary btn_outlined uppercase">View</a>
								</td>
								<td class="text-center">
									<a href="machines/edit/<?php echo  $machine['asset_id']; ?>" class="btn btn_primary uppercase">Edit</a>
								</td>
								<td class="text-center">
									<?php echo form_open('machines/delete/' . $machine['asset_id']); ?>
									<input type="submit" name="delete_machine" value="Delete" class="btn btn_danger text-gray-300">
									</form>
								</td>

							</tr>

						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

<!-- Script

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
-->

<!-- Datatables
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script>
	$(document).ready(function() {
		$('#asset-table').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		} );
	} );
</script>
-->