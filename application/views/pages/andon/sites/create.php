<!-- Breadcrumb -->
<section class="breadcrumb">
    <h1><?= $title ?></h1>
    <ul>
    <li><a href= "<?php echo base_url(); ?>index.php" >Home</a></li>
        <li class="divider la la-arrow-right"></li>
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
					<label class="label block mb-2" for="plant_id">Select Plant:</label>
					<select class="form-control" id="plant_id" name="plant_id" required>
						<option value="">Select Option</option>
						<?php foreach ($plants as $plant) : ?>
							<option value="<?php echo $plant["plant_id"] ?>"><?php echo $plant["plant_name"] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="lg:col-span-2 xl:col-span-2">
					<label class="label block mb-2" for="site_id">Area name:</label>
					<input class="form-control"  id="site_id" name="site_name">
				</div>
			</div>
			<div class="flex justify-end mt-5">
				<button type="submit" name="save_site" class="btn btn_success">Save Site</button>
			</div>

		</form>

	</div>
</div>
