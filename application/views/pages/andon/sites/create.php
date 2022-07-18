<!-- Breadcrumb -->
<section class="breadcrumb">
	<h1><?= $title ?></h1>
	<ul>
		<!--<li><a href="<?php echo base_url(); ?>index.php">Home</a></li>
		<li class="divider la la-arrow-right"></li>-->
		<li><?= $title ?></li>
	</ul>
</section>
<!-- Content -->
<div class="lg:col-span-2 xl:col-span-3">
	<div class="card p-5">

		<?php echo validation_errors(); ?>

		<?php echo form_open('sites/create') ?>

		<div class="grid lg:grid-cols-4 gap-5">
			<div class="lg:col-span-2 xl:col-span-2">
				<label class="label block mb-2" for="plant_id">Selecciona una planta:</label>
				<select class="form-control" id="plant_id" name="plant_id" required>
					<option value="">Selecciona una opcion</option>
					<?php foreach ($plants as $plant) : ?>
						<option value="<?php echo $plant["plant_id"] ?>"><?php echo $plant["plant_name"] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="lg:col-span-2 xl:col-span-2">
				<label class="label block mb-2" for="site_id">Nombre del area:</label>
				<input class="form-control" id="site_id" name="site_name" required>
			</div>
		</div>
		<div class="flex justify-end mt-5">
			<button type="submit" name="save_site" class="btn btn_success">Guardar Celda</button>
		</div>

		</form>

	</div>
</div>

<script>
	function display_message(title, message) {
		swal(title, message, "<?= $message_type ?>")
			.then((value) => {
				window.location.href = '<?= base_url() ?>sites';
			});
	}

	<?php
	if (isset($message_title) && isset($message_description)) {
		echo 'display_message("' . $message_title . '", "' . $message_description . '");';
	}
	?>
</script>