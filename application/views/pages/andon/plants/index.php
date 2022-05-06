<!-- Breadcrumb -->
<section class="breadcrumb">
    <h1><?= $title ?></h1>
    <ul>
        <li><a href="<?php echo base_url(); ?>index.php">Home</a></li>
        <li class="divider la la-arrow-right"></li>
        <li><?= $title ?></li>
    </ul>
</section>
<div class="flex flex-wrap gap-2 items-center ltr:ml-auto rtl:mr-auto mt-5 lg:mt-0">
    <div class="flex gap-x-2 mb-5">
        <!-- Add New -->
        <a href="<?php echo base_url() ?>plants/create" class="btn btn_primary uppercase">Add New Plants</a>
    </div>
</div>
<div class="grid lg:grid-cols-1 gap-5">
    <!-- Content -->
    <div class="lg:col-span-3 xl:col-span-3">
        <div class="card p-5">

            <div class="mt-5">
                <table id="asset-table" class="table table-auto table_hoverable w-full mb-5">
                    <thead>
                        <tr>
                            <th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Plant ID</th>
                            <th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Plant name</th>
                            <th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Status</th>
                            <th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Actions</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php
                        foreach ($plants as $plant) :
                        ?>

                            <tr>
                                <td class="text-center"><?php echo $plant['plant_id'] ?></td>
                                <td class="text-center"><?php echo $plant['plant_name'] ?></td>
                                <td class="text-center"><?php if ($plant['plant_use_password'] == 1) {
                                                            echo "Password Protected";
                                                        } else {
                                                            echo "Not Protected";
                                                        } ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="plants/edit/<?php echo $plant['plant_id'] ?>" class="btn btn_warning uppercase"><span class="icon las la-edit la-2x"></span></a>
                                        <a href="plants/confirm_delete/<?php echo $plant['plant_id'] ?>" class="btn btn_danger uppercase"><span class="icon las la-trash la-2x"></span></a>
                                    </div>
                                </td>

                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>