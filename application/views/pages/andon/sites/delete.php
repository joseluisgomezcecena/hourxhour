<!-- Breadcrumb -->
<section class="breadcrumb">
	<h1><?= $title ?></h1>
	<ul>
		<li><a href="<?php echo base_url(); ?>index.php">Home</a></li>
		<li class="divider la la-arrow-right"></li>
		<li><?= $title ?></li>
	</ul>
</section>
<!-- Content -->
<div class="lg:col-span-2 xl:col-span-3">
	<div class="card p-5">

		<h2 class="text-center mb-4">Do you really want to delete this Site?</h2>

		<?php echo form_open('sites/delete') ?>

		<input type="hidden" name="id" value="<?php echo $site['site_id'] ?>" />
		<div class="grid lg:grid-cols-4 gap-5">
			<div class="lg:col-span-2 xl:col-span-2">
				<label class="label block mb-2" for="plant_id">Select Plant:</label>
				<select class="form-control" id="plant_id" name="plant_id" disabled>
					<option value="">Select Option</option>
					<?php foreach ($plants as $plant) : ?>
						<option <?php if ($site['plant_id'] == $plant['plant_id']) {
									echo "selected";
								} else {
									echo "";
								} ?> value="<?php echo $plant["plant_id"] ?>"><?php echo $plant["plant_name"] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="lg:col-span-2 xl:col-span-2">
				<label class="label block mb-2" for="site_id">Area name:</label>
				<input class="form-control" id="site_id" name="site_name" value="<?php echo $site['site_name']; ?>" disabled>
			</div>
		</div>
		<div class="flex justify-end mt-5">
			<a href="<?php echo base_url() ?>sites" name="save_site" class="btn btn_secondary ltr:mr-2">Cancel</a>
			<button type="submit" name="save_site" class="btn btn_danger">DELETE SITE</button>
		</div>

		</form>

	</div>
</div>