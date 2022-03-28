<!-- Breadcrumb -->
<section class="breadcrumb">
    <h1><?= $title ?></h1>
    <ul>
        <li><a href="#">Pages</a></li>
        <li class="divider la la-arrow-right"></li>
        <li><?= $title ?></li>
    </ul>
</section>
<!-- Content -->
<div class="lg:col-span-2 xl:col-span-3">
    <div class="card p-5">
        <div class="grid lg:grid-cols-4 gap-5">
            <div class="lg:col-span-2 xl:col-span-2">
                <label class="label block mb-2" for="site_id">Plant name:</label>
                <input class="form-control" type="text" id="site_id">
            </div>
            <div class="lg:col-span-2 xl:col-span-2">
                <label class="label block mb-2" for="site_id">Password:</label>
                <input class="form-control" type="password" id="site_id">
            </div>
        </div>
        <div class="flex justify-end mt-5">
            <button class="btn btn_success">Save Plant</button>
        </div>
    </div>
</div>