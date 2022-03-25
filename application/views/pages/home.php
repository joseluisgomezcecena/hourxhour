	<!-- Breadcrumb -->
	<section class="breadcrumb">
	    <h1><?= $title ?></h1>
	    <ul>
	        <li><a href="#">Pages</a></li>
	        <li class="divider la la-arrow-right"></li>
	        <li><?= $title ?></li>
	    </ul>
	    <div class="grid lg:grid-cols-1 gap-5 mt-5">
	        <!-- Summaries -->
	        <div class="grid sm:grid-cols-3 gap-5">
	            <div class="card px-4 py-8 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
	                <div>
	                    <span class="text-primary text-5xl leading-none las la-industry"></span>
	                    <p class="mt-2">Moldeo</p>
	                    <div class="text-primary mt-5 text-3xl leading-none">18</div>
	                </div>
	            </div>
	            <div class="card px-4 py-8 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
	                <div>
                    <span class="text-primary text-5xl leading-none las la-industry"></span>
	                    <p class="mt-2">Ensamble</p>
	                    <div class="text-primary mt-5 text-3xl leading-none">16</div>
	                </div>
	            </div>
	            <div class="card px-4 py-8 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
	                <div>
                    <span class="text-primary text-5xl leading-none las la-industry"></span>
	                    <p class="mt-2">Planta 3</p>
	                    <div class="text-primary mt-5 text-3xl leading-none">9</div>
	                </div>
	            </div>
	        </div>
	        <!-- PLANNED INTERRUPTION CHART -->
	        <div class="card p-5 flex flex-col min-w-0">
	            <h3>PLANNED INTERRUPTION</h3>
	            <div class="flex-auto mt-5 min-w-0">
	                <canvas id="categoriesChart"></canvas>
	            </div>
	        </div>
	    </div>
	</section>
	<script src="<?php echo  base_url() ?>assets/js/chart.min.js"></script>