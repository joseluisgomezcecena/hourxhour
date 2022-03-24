<!-- Breadcrumb -->
<section class="breadcrumb">
	<h1><?= $title ?></h1>
	<ul>
		<li><a href="#">Pages</a></li>
		<li class="divider la la-arrow-right"></li>
		<li><?= $title ?></li>
	</ul>
</section>


<div class="grid lg:grid-cols-4 gap-5">

	<!-- Content -->
	<div class="lg:col-span-2 xl:col-span-3">
		<div class="card p-5">
			<form>

				<div class="grid lg:grid-cols-4 gap-5">
					<div class="lg:col-span-2 xl:col-span-2">
						<label class="label block mb-2" for="plant_id">Select Plant:</label>
						<select class="form-control"  id="plant_id"  name="plant_id" required>
							<option value="">Select Option</option>
							<?php foreach ($plants as $plant): ?>
								<option value="<?php echo $plant["plant_id"] ?>"><?php echo $plant["plant_name"] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="lg:col-span-2 xl:col-span-2">
						<label class="label block mb-2" for="site_id">Select Site or Cell:</label>
						<select class="form-control"  id="site_id"  name="site_id" required>

						</select>
					</div>
					<div class="lg:col-span-1 xl:col-span-2">
						<label class="label block mb-2" for="work_center">Work Center:</label>
						<input class="form-control"  id="work_center"  name="work_center" required>
					</div>
					<div class="lg:col-span-1 xl:col-span-2">
						<label class="label block mb-2" for="machine_name">Machine Name:</label>
						<input class="form-control"  id="machine_name"  name="machine_name" required>
					</div>
					<div class="lg:col-span-2 xl:col-span-2">
						<label class="label block mb-2" for="machine_control_number">Control Number:</label>
						<input class="form-control"  id="machine_control_number"  name="machine_control_number" >
					</div>
				</div>


				<div class="mb-5">
					<label class="label block mb-2" for="content">Observations</label>
					<textarea id="content" class="form-control" name="observations" rows="16"></textarea>
				</div>

			</form>
		</div>
	</div>

	<div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">

		<!-- Publish -->
		<div class="card p-5 flex flex-col gap-y-5">
			<h3>Save Machine</h3>
			<form class="flex flex-col gap-y-5">
				<div class="flex items-center">
					<div class="w-1/4">
						<label class="label block">Category</label>
					</div>
					<div class="w-3/4 ml-2">
						<div class="custom-select">
							<select class="form-control">
								<option value="1">Molding</option>
								<option value="0">Assembly</option>
							</select>
							<div class="custom-select-icon la la-caret-down"></div>
						</div>
					</div>
				</div>

				<div class="flex items-center">
					<div class="w-1/4">
						<label class="label block">Point of measure</label>
					</div>
					<div class="w-3/4 ml-2">
						<label class="label switch">
							<input type="checkbox">
							<span></span>
							<span>Yes</span>
						</label>
					</div>
				</div>
			</form>
			<div class="flex flex-wrap gap-2 mt-5">
				<button class="btn btn_primary uppercase">Save Machine</button>
			</div>
		</div>
	</div>
</div>

<!-- Script -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type='text/javascript'>
	// baseURL variable
	var baseURL= "<?php echo base_url();?>";

	$(document).ready(function() {
		// City change
		$('#plant_id').change(function () {
			alert("hola");

			var city = $(this).val();

			// AJAX request
			$.ajax({
				url: '<?=base_url()?>index.php/Machines/getCityDepartment',
				method: 'post',
				data: {plant_id: city},
				dataType: 'json',
				success: function (response) {

					// Remove options
					//$('#sel_user').find('option').not(':first').remove();
					//$('#site_id').find('option').not(':first').remove();
					$('#site_id').find('option').remove();
					// Add options
					$.each(response, function (index, data) {
						$('#site_id').append('<option value="' + data['site_id'] + '">' + data['site_name'] + '</option>');
					});
				}
			});
		});
	});
</script>
