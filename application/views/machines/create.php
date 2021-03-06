<!-- Breadcrumb -->
<section class="breadcrumb">
	<h1><?= $title ?></h1>
	<ul>
		<!--<li><a href="#">Pages</a></li>
		<li class="divider la la-arrow-right"></li>-->
		<li><?= $title ?></li>
	</ul>
</section>


<?php echo validation_errors(); ?>

<?php echo form_open('machines/create') ?>
<div class="grid lg:grid-cols-4 gap-5">

	<!-- Content -->
	<div class="lg:col-span-2 xl:col-span-3">
		<div class="card p-5">


				<div class="grid lg:grid-cols-4 gap-5">
					<div class="lg:col-span-2 xl:col-span-2">
						<label class="label block mb-2" for="plant_id">Selecciona una planta:</label>
						<select class="form-control"  id="plant_id"  name="plant_id" required>
							<option value="">Selecciona una opcion</option>
							<?php foreach ($plants as $plant): ?>
								<option value="<?php echo $plant["plant_id"] ?>"><?php echo $plant["plant_name"] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="lg:col-span-2 xl:col-span-2">
						<label class="label block mb-2" for="site_id">Selecciona celda:</label>
						<select class="form-control"  id="site_id"  name="site_id" required>

						</select>
					</div>
					<div class="lg:col-span-1 xl:col-span-2">
						<label class="label block mb-2" for="work_center">Centro de trabajo de la maquina:</label>
						<input class="form-control"  id="work_center"  name="work_center" required>
					</div>
					<div class="lg:col-span-1 xl:col-span-2">
						<label class="label block mb-2" for="machine_name">Nombre de la maquina:</label>
						<input class="form-control"  id="machine_name"  name="machine_name" required>
					</div>
					<div class="lg:col-span-2 xl:col-span-2">
						<label class="label block mb-2" for="machine_control_number">Numero de control de maquina:</label>
						<input class="form-control"  id="machine_control_number"  name="machine_control_number" >
					</div>
				</div>


				<div class="mb-5 my-5">
					<label class="label block mb-2" for="content">Observaciones</label>
					<textarea id="content" class="form-control" name="observations" rows="16"></textarea>
				</div>


		</div>
	</div>

	<div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">

		<!-- Publish -->
		<div class="card p-5 flex flex-col gap-y-5">
			<h3>Andon Categoria</h3>
			<form class="flex flex-col gap-y-5">
				<div class="flex items-center">
					<div class="w-1/4">
						<label class="label block">Categoria</label>
					</div>
					<div class="w-3/4 ml-2">
						<div class="custom-select">
							<select name="machine_station" class="form-control">
								<option value="1">Moldeo</option>
								<option value="0">Ensamble</option>
							</select>
							<div class="custom-select-icon la la-caret-down"></div>
						</div>
					</div>
				</div>

				<div class="flex items-center">
					<div class="w-1/4">
						<label class="label block">Activar punto de medicion</label>
					</div>
					<div class="w-3/4 ml-2">
						<label class="label switch">
							<input name="pom" type="checkbox" value="1">
							<span></span>
							<span>Activar</span>
						</label>
					</div>
				</div>
			</form>
			<div class="flex flex-wrap gap-2 mt-5">
				<button type="submit" name="save_machine" class="btn btn_primary uppercase">Guardar punto de medicion</button>
			</div>
		</div>
	</div>
</form>

</div>

<!-- Script -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type='text/javascript'>
	// baseURL variable
	var baseURL= "<?php echo base_url();?>";

	$(document).ready(function() {
		// Plant change
		$('#plant_id').change(function () {

			var plant_id = $(this).val();

			// Ajax request
			$.ajax({
				url: '<?=base_url()?>index.php/Machines/get_sites',
				method: 'post',
				data: {plant_id: plant_id},
				dataType: 'json',
				success: function (response) {

					$('#site_id').find('option').remove();
					// fill select
					$.each(response, function (index, data) {
						$('#site_id').append('<option value="' + data['site_id'] + '">' + data['site_name'] + '</option>');
					});
				}
			});
		});
	});
</script>

<script>
	function display_message(title, message) {
		swal(title, message, "<?= $message_type ?>")
			.then((value) => {
				window.location.href = '<?= base_url() ?>machines';
			});
	}

	<?php
	if (isset($message_title) && isset($message_description)) {
		echo 'display_message("' . $message_title . '", "' . $message_description . '");';
	}
	?>
</script>