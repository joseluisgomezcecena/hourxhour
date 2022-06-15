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
                <form action="<?= base_url() ?>import_report/std_hours/import" method="post" enctype="multipart/form-data" onSubmit="return validateForm()">
                    <div class="grid lg:grid-cols-3 gap-5 my-5">
                        <div class="text-success">
                            <label for="date" class="mx-5"><b>Fecha de reporte</b></label>
                            <input id="date" type="date" name="date" class="mr-3" required>
                        </div>
                        <div class="text-success">
                            <input id="file" type="file" name="file[]" accept=".csv" required multiple>
                        </div>
                        <div>
                            <button id="submit" type="submit" class="btn btn_info uppercase" name="submit_file">Import CSV</button>
                        </div>
                    </div>
                </form>
                <table id="report-table" class="table table-auto w-full mb-5">
                    <thead>
                        <tr>
                            <th style="font-size: 11px !important;" class="text-center uppercase">#</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Item</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Desc</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Planner</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Whs</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Posted</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Posted Time</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Txn</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Order</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Quantity</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Run labor (item x min)</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Setup minutes</th>


                        </tr>
                    </thead>
                    <tbody>

                        //items_by_minutes
                        <?php foreach ($items_by_minutes as $item) : ?>
                            <tr>
                                <td class="text-center"><?= $item['id']; ?></td>
                                <td class="text-center"><?= $item['item']; ?></td>
                                <td class="text-center"><?= $item['description']; ?></td>
                                <td class="text-center"><?= $item['planner']; ?></td>
                                <td class="text-center"><?= $item['whs']; ?></td>
                                <td class="text-center"><?= $item['posted']; ?></td>
                                <td class="text-center"><?= $item['posted_time']; ?></td>
                                <td class="text-center"><?= $item['txn']; ?></td>
                                <td class="text-center"><?= $item['order_number']; ?></td>
                                <td class="text-center"><?= $item['quantity']; ?></td>
                                <td class="text-center"><?= $item['run_labor_mins_per_item']; ?></td>
                                <td class="text-center"><?= $item['setup_mins']; ?></td>

                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function validateForm() {

        if (file.value === "") {
            swal("Something was wrong!", "File not found.", "error");
            return false;
        } else {
            //submit_csv.submit();
            //console.log(submit_csv);
            return true;
        }


    }
</script>

<!--<script>
	function display_message(title, message) {
		swal(title, message, "<?= $message_type ?>")
			.then((value) => {
				window.location.href = '<?= base_url() ?>import_report/tempus';
			});
	}

	<?php
    if (isset($message_title) && isset($message_description)) {
        echo 'display_message("' . $message_title . '", "' . $message_description . '");';
    }
    ?>
</script>-->