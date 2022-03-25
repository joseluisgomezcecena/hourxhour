<!-- Breadcrumb -->
<section class="breadcrumb">
	<h1><?= $title ?></h1>
	<ul>
		<li><a href="#">Pages</a></li>
		<li class="divider la la-arrow-right"></li>
		<li><?= $title ?></li>
	</ul>
</section>


<div class="grid lg:grid-cols-1 gap-5">

	<!-- Content -->
	<div class="lg:col-span-3 xl:col-span-3">
		<div class="card p-5">

			<table id="asset-table" class="table table-auto table_hoverable w-full">
				<thead>
				<tr>
					<th class="text-center uppercase">Asset</th>
					<th class="ltr:text-left rtl:text-right uppercase">Work Center</th>
					<th class="text-center uppercase">Control Number</th>
				</tr>
				</thead>


				<tbody>
					<?php foreach ($machines as $machine): ?>
					<tr>
						<td class="text-center"><?php echo $machine['asset_name'] ?></td>
						<td class="text-center"><?php echo $machine['asset_name'] ?></td>
						<td class="text-center"><?php echo $machine['asset_name'] ?></td>
					</tr>

					<?php endforeach; ?>
				</tbody>
			</table>

		</div>
	</div>

</div>

<!-- Script-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Datatables -->
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
