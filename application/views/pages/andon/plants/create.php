<!-- Breadcrumb -->
<section class="breadcrumb">
    <h1><?= $title ?></h1>
    <ul>
        <li><a href="<?php echo base_url(); ?>index.php">Inicio</a></li>
        <li class="divider la la-arrow-right"></li>
        <li><?= $title ?></li>
    </ul>
</section>
<?php echo form_open('plants/create') ?>
<div class="grid lg:grid-cols-4 gap-5">

    <!-- Content -->
    <div class="lg:col-span-2 xl:col-span-3">
        <div class="card p-5">


            <div class="grid lg:grid-cols-4 gap-5">

                <div class="lg:col-span-2 xl:col-span-2">
                    <label class="label block mb-2" for="work_center">Plant Name:</label>
                    <input class="form-control" id="work_center" name="plant_name" required>
                </div>
                <div class="lg:col-span-2 xl:col-span-2">
                    <label class="label block mb-2" for="machine_name">Plant Password:</label>
                    <input class="form-control" type="password" id="machine_name" name="plant_password" required>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">
        <!-- Publish -->
        <div class="card p-5 flex flex-col gap-y-5">
            <h3>Security</h3>
            <form class="flex flex-col gap-y-5">
                <div class="flex items-center">
                    <div class="w-2/4">
                        <label class="label block">Password Protected</label>
                    </div>
                    <div class="w-2/4 ml-2">
                        <label class="label switch">
                            <input name="plant_use_password" type="checkbox" value="1">
                            <span></span>
                            <span>Yes</span>
                        </label>
                    </div>
                </div>
            </form>
            <div class="flex flex-wrap gap-2 mt-5">
                <button type="submit" name="save_plant" class="btn btn_primary uppercase">Save Plant</button>
            </div>
        </div>
    </div>
    </form>
</div>
<script>
	function display_message(title, message) {
		swal(title, message, "<?= $message_type ?>")
			.then((value) => {
				window.location.href = '<?= base_url() ?>plants';
			});
	}

	<?php
	if (isset($message_title) && isset($message_description)) {
		echo 'display_message("' . $message_title . '", "' . $message_description . '");';
	}
	?>
</script>