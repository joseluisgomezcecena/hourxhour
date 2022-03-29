<!-- Breadcrumb -->
<section class="breadcrumb">
	<h1><?=  $title ?></h1>
	<ul>
		<li><a href="#">Pages</a></li>
		<li class="divider la la-arrow-right"></li>
		<li><a href="#"><?=  $title ?></a></li>
		<li class="divider la la-arrow-right"></li>
		<li><?php echo $machines['asset_name'] ?></li>
	</ul>
</section>

<div class="grid lg:grid-cols-4 gap-5">

	<!-- Categories -->
	<div class="lg:col-span-2 xl:col-span-1">
		<div class="card p-5">
			<h3>Location Details</h3>
			<div class="mt-5 leading-normal">
				<a href="#" class="flex items-center text-normal">
					<span class="las la-cog text-muted text-2xl ltr:mr-2 rtl:ml-2"></span>
					Asset Name: <?php echo $machines['asset_name'] ?>
				</a>
				<a href="#" class="flex items-center text-normal">
					<span class="las la-info-circle text-muted text-2xl ltr:mr-2 rtl:ml-2"></span>
					Work Center: <?php echo $machines['asset_work_center'] ?>
				</a>
				<a href="#" class="flex items-center text-normal">
					<span class="las la-info-circle text-muted text-2xl ltr:mr-2 rtl:ml-2"></span>
					Control Number: <?php echo $machines['asset_control_number'] ?>
				</a>
				<hr class="my-2">

				<a href="#" class="flex items-center text-normal">
					<span class="la la-info-circle text-muted text-2xl ltr:mr-2 rtl:ml-2"></span>
					Plant: <?php echo $machines['plant_name'] ?>
				</a>
				<hr class="my-2">
				<a href="#" class="flex items-center text-normal">
					<span class="la la-info-circle text-muted text-2xl ltr:mr-2 rtl:ml-2"></span>
					Site: <?php echo $machines['site_name'] ?>
				</a>
			</div>
		</div>
	</div>

	<!-- FAQs -->
	<div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-3">
		<div class="card p-5">
			<h3>Asset Details for <?php echo $machines['asset_name'] ?></h3>
			<div class="accordion border border-divider rounded-xl mt-5">
				<h5 class="border-t border-divider p-5 active" data-toggle="collapse"
					data-target="#faqs-2-3">
					Category
					<span class="collapse-indicator la la-arrow-circle-down"></span>
				</h5>
				<div id="faqs-2-3" class="collapse open">
					<div class="p-5 pt-0">
						<?php
						echo ($machines['asset_is_machine'] == 1) ? "Molding Machine." : "Work Station.";
						?>
					</div>
				</div>
				<h5 class="border-t border-divider p-5 active" data-toggle="collapse"
					data-target="#faqs-2-3">
					Point of Measure
					<span class="collapse-indicator la la-arrow-circle-down"></span>
				</h5>
				<div id="faqs-2-3" class="collapse open">
					<div class="p-5 pt-0">
						<?php
						echo ($machines['asset_is_pom'] == 1) ? "Hour by Hour Point of Measure." : "Not Point of Measure.";
						?>
					</div>
				</div>


			</div>
		</div>
		<div class="card p-5">
			<h3>Database details</h3>
			<div class="accordion border border-divider rounded-xl mt-5">
				<h5 class="p-5 active" data-toggle="collapse" data-target="#faqs-2">
					Data Details
					<span class="collapse-indicator la la-arrow-circle-down"></span>
				</h5>
				<div id="faqs-2" class="collapse open">
					<div class="p-5 pt-0">
						Created at: <?php echo dateFormat('d/m/Y',$machines['created_at']); ?>
						<br>
						Last updated: <?php echo dateFormat('d/m/Y',$machines['updated_at']); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
