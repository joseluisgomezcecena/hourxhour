<?php 
    if(isset($_POST["submit_file"]))
    {

        $date = date('Y/m/d', strtotime($_POST['date']));
        $columna = 2;
        $columna_supervisor = 0;

        echo $date;

        echo 'hola';

        switch(date('w', strtotime($_POST['date']))) 
        {
            case 1: // Martes -> Nos dara reporte de Lunes
                $columna = 2;
                break;
            case 2: // Miercoles -> Nos dara reporte de Martes
                $columna = 4;
                break;
            case 3: // Jueves -> Nos dara reporte de Miercoles
                $columna = 6;
                break;
            case 4: // Viernes -> Nos dara reporte de Jueves
                $columna = 8;
                break;
            case 5: // Sabado -> Nos dara reporte de Viernes
                $columna = 10;
                break;
            case 6: // Domingo -> Nos dara reporte de Sabado
                $columna = 12;
                break;
            case 7: // Lunes -> Nos dara reporte de Domingo
                $columna = 14;
                break;
            default:
                $columna = 2;
                break;
        }
    }
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
            <form id="submit_csv" action="index.php?page=import_tempus" method="post" enctype="multipart/form-data">
                <div class="grid lg:grid-cols-3 gap-5 my-5">
                        <div class="text-success">
                            <label for="datef" class="mx-5"><b>Fecha de reporte</b></label>
                            <input id="date" type="date" name="date" class="mr-3" required>
                        </div>
                        <div class="text-success">
                        <input id="file" type="file" name="file" accept=".csv" required>
                        </div>
                        <div>
                            <input id="submit" type="button" class="btn btn_info uppercase" name="submit_file" value="Import CSV" />
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
    submit.addEventListener('click', validateFile);
    function validateFile() {
        if (file.value === "") {
            swal("Something was wrong!", "File not found.", "error");
        } else {
            //submit_csv.submit();
            console.log(submit_csv);
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