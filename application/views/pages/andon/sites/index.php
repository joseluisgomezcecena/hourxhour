<!-- Breadcrumb -->
<section class="breadcrumb">
    <h1><?= $title ?></h1>
    <ul>
    <li><a href= "<?php echo base_url(); ?>index.php" >Home</a></li>
        <li class="divider la la-arrow-right"></li>
        <li><?= $title ?></li>
    </ul>
</section>
<div class="flex flex-wrap gap-2 items-center ltr:ml-auto rtl:mr-auto mt-5 lg:mt-0">
    <div class="flex gap-x-2 mb-5">
        <!-- Add New -->
        <a href="<?php echo base_url() ?>sites/create" class="btn btn_primary uppercase">Add New Sites</a>
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
                            <th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Site ID</th>
                            <th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Site name</th>
                            <th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Parent Plant</th>
                            <th style="font-size: 14px !important; width: 150px;" class="text-center uppercase">Actions</th>
                        </tr>
                    </thead>


                    <tbody>

						<?php foreach ($sites as $site): ?>

                        <tr>
                            <td class="text-center"><?php echo $site['site_id']; ?></td>
                            <td class="text-center"><?php echo $site['site_name']; ?></td>
                            <td class="text-center"><?php echo $site['plant_name']; ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="sites/edit/<?php echo $site['site_id']; ?>" class="btn btn_warning uppercase"><span class="icon las la-edit la-2x"></span></a>
                                    <button type="button" class="btn btn_danger uppercase"><span class="icon las la-trash la-2x"></span></button>
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
