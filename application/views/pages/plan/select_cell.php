	<!-- Breadcrumb -->
	<section class="breadcrumb">
	    <h1><?= $title ?></h1>
	    <ul>
	        <li><a href="#">Pages</a></li>
	        <li class="divider la la-arrow-right"></li>
	        <li><?= $title ?></li>
	    </ul>
	    <div class="grid lg:grid-cols-4 gap-5 p-5">
	        <div class="card p-5">
	            <div class="items-center px-5 py-2">
	                <h5 class="mb-0 uppercase">Ensamble</h5>
	                <small>Selet a cell</small>
	            </div>
	            <hr>
	            <table class="table table_list mt-3 w-full">
	                <thead>
	                    <tr>
	                        <th class="ltr:text-left rtl:text-right uppercase"><a href="<?php echo base_url(); ?>index.php/measuring_point">Title</a></th>
	                        <th class="w-px uppercase">
	                            <div class="badge badge_warning uppercase">1</div>
	                        </th>
	                    </tr>
                        <tr>
                        <th class="ltr:text-left rtl:text-right uppercase"><a href="#">Title</a></th>
	                        <th class="w-px uppercase">
	                            <div class="badge badge_warning uppercase">1</div>
	                        </th>
	                    </tr>
                        <tr>
                        <th class="ltr:text-left rtl:text-right uppercase"><a href="#">Title</a></th>
	                        <th class="w-px uppercase">
	                            <div class="badge badge_warning uppercase">1</div>
	                        </th>
	                    </tr>
	                </thead>
	            </table>
	        </div>
	    </div>
	</section>