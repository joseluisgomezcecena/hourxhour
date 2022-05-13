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
                <form action="<?= base_url() ?>import_report/import_std_hours" method="post" enctype="multipart/form-data" onSubmit="return validateForm()">
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
                            <th style="font-size: 11px !important;" class="text-center uppercase">Txn</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Order</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Quantity</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Class</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Run Labor</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Yield</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Setup hours</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Std hours</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">item</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
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