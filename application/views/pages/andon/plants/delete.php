<!-- Breadcrumb -->
<section class="breadcrumb">
	<h1><?= $title ?></h1>
	<ul>
		<li><a href="<?php echo base_url(); ?>index.php">Inicio</a></li>
		<li class="divider la la-arrow-right"></li>
		<li><?= $title ?></li>
	</ul>
</section>


<div class="lg:col-span-2 xl:col-span-3">
	<div class="card p-5">

		<h2 class="text-center mb-4">Do you really want to delete this Plant?</h2>

		<?php echo form_open('plants/delete') ?>



		<div class="grid lg:grid-cols-4 gap-5">

			<input type="hidden" name="id" value="<?php echo $plant['plant_id']; ?>">

			<div class="lg:col-span-2 xl:col-span-2">
				<label class="label block mb-2" for="work_center">Plant Name:</label>
				<input class="form-control" id="work_center" name="plant_name" value="<?php echo $plant['plant_name']; ?>" required>
			</div>
			<div class="lg:col-span-2 xl:col-span-2">
				<label class="label block mb-2" for="machine_name">Plant Password:</label>
				<input class="form-control" type="password" id="machine_name" name="plant_password" value="<?php echo $plant['plant_password']; ?>" required>
			</div>

		</div>


		<div class="flex justify-end mt-5">
			<a href="<?php echo base_url() ?>plants" name="cancel_plant" class="btn btn_secondary ltr:mr-2">Cancel</a>
			<button type="submit" name="save_plant" class="btn btn_danger">DELETE SITE</button>
		</div>

		</form>

	</div>
</div>