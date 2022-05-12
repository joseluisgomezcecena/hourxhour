<?php

?>

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
                <form id="submit_csv" action="<?php echo base_url(); ?>reports/import_tempus_reports_post" onsubmit="return validateFile()" method="post" enctype="multipart/form-data">
                    <div class="grid lg:grid-cols-3 gap-5 my-5">
                        <div class="text-success">
                            <label for="date" class="mx-5"><b>Fecha de reporte</b></label>
                            <input id="date" type="date" name="date" class="mr-3" required>
                        </div>
                        <div class="text-success">
                            <input id="file" type="file" name="file" accept=".csv" required>
                        </div>
                        <div>
                            <input id="submit" type="submit" name="submit_tempus_file" class="btn btn_info uppercase" value="Import CSV" />
                        </div>
                    </div>
                </form>
                <table id="report-table" class="table table-auto w-full mb-5">
                    <thead>
                        <tr>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Employee number</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Employee</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Hours</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Supervisor</th>
                            <th style="font-size: 11px !important;" class="text-center uppercase">Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    //submit.addEventListener('click', validateFile);

    function validateFile() {
        if (file.value === "") {
            swal("Something was wrong!", "File not found.", "error");

            return false;
        } else {
            //submit_csv.submit();
            console.log(submit_csv);
            return true;
        }
    }
</script>