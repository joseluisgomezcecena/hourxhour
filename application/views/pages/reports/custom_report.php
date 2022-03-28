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

			<div class="mt-5">
				<table id="asset-table" class="table table-auto table_hoverable w-full mb-5">
					<thead >
					<tr>
						<th style="font-size: 12px !important; width: 150px;" class="text-center uppercase">Work order</th>
						<th style="font-size: 12px !important; width: 150px;" class="text-center uppercase">Item</th>
						<th style="font-size: 12px !important; width: 150px;" class="text-center uppercase">Quantity</th>
						<th style="font-size: 12px !important; width: 150px;" class="ltr:text-center rtl:text-right uppercase">Machine</th>
						<th style="font-size: 12px !important; width: 150px;" class="text-center uppercase">Date start</th>
						<th style="font-size: 12px !important; width: 150px;" class="text-center uppercase">Date end</th>
						<th style="font-size: 12px !important; width: 150px;" class="text-center uppercase">PPH Standard</th>
                        <th style="font-size: 12px !important; width: 150px;" class="text-center uppercase">Quantity Shift one</th>
                        <th style="font-size: 12px !important; width: 150px;" class="text-center uppercase">Quantity Shift two</th>
                        <th style="font-size: 12px !important; width: 150px;" class="text-center uppercase">Quantity Shift three</th>
                        <th style="font-size: 12px !important; width: 150px;" class="text-center uppercase">Total hours</th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-center">MPMG370</td>
                            <td class="text-center">AC7802A</td>
							<td class="text-center">500</td>
                            <td class="text-center">ATJ01</td>
                            <td class="text-center">03/30/2021 17:13:00</td>
							<td class="text-center">03/31/2021 09:21:13</td>
                            <td class="text-center">100</td>
                            <td class="text-center">547</td>
							<td class="text-center">1550</td>
                            <td class="text-center">1720</td>
                            <td class="text-center">16.13 horas</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>