<style>
    th {
        color: black;
    }

    .table-success {
        background-color: #b8efc1 !important;
    }

    .table-green {
        background-color: #059669;
    }

    .table-warning {
        background-color: #ede4b6 !important;
    }

    .table-danger {
        background-color: #edb6b6 !important;
    }

    .table-gray {
        background-color: #e0e0e0 !important;
    }

    td {
        text-align: center;
    }
</style>
<section class="breadcrumb">
    <h1><?= $title ?></h1>
    <ul>
    <li><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="divider la la-arrow-right"></li>
        <li><?= $title ?></li>
    </ul>
    <table class="table w-full mt-3">
        <thead>
            <tr>
                <th class="uppercase table-green">Plant</th>
                <th class="uppercase table-success">Ensamble</th>
                <th class="uppercase table-green">Area</th>
                <th class="uppercase table-success">Dilators</th>
                <th class="uppercase table-green">Output</th>
                <th class="uppercase table-success">BOY 25</th>
                <th class="uppercase table-green">Shift status</th>
                <th class="uppercase table-success">99%</th>
            </tr>
        </thead>
    </table>
    <table class="table w-full mt-5">
        <thead>
            <tr>
                <th class="uppercase table-green">HR</th>
                <th class="uppercase table-green">HC</th>
                <th class="uppercase table-green">Item Number</th>
                <th class="uppercase table-green">WO Number</th>
                <th class="uppercase table-green">Plan By Hour</th>
                <th class="uppercase table-green">CUM Plan</th>
                <th class="uppercase table-green">Output QTY</th>
                <th class="uppercase table-green">CUM Output</th>
                <th class="uppercase table-green">Interruption Cause</th>
                <th class="uppercase table-green">Less Time</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>6:00-7:00</b></td>
                <td>10</td>
                <td>AAC19521</td>
                <td>GFC-00</td>
                <td>200</td>
                <td>200</td>
                <td>400</td>
                <td>200</td>
                <td>Material shortage</td>
                <td>0.5</td>
            </tr>
            <tr> 
                <td><b>7:00-8:00</b></td>
                <td>35</td>
                <td>10034-815-401C</td>
                <td>GFC-01</td>
                <td>450</td>
                <td>650</td>
                <td>200</td>
                <td>300</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>8:00-9:00</b></td>
                <td>20</td>
                <td>AAC19521</td>
                <td>GFC-02</td>
                <td>115</td>
                <td>765</td>
                <td>650</td>
                <td>114</td>
                <td>Learning curve</td>
                <td>0.25</td>
            </tr>
            <tr>
                <td><b>9:00-10:00</b></td>
                <td>16</td>
                <td>10085-228</td>
                <td>GFC-03</td>
                <td>650</td>
                <td>1,415</td>
                <td>500</td>
                <td>200W</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</section>