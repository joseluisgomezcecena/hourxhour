	<!-- Breadcrumb -->
	<section class="breadcrumb">
	    <h1><?= $title ?></h1>
	    <ul>
	        <li><a href="#">Pages</a></li>
	        <li class="divider la la-arrow-right"></li>
	        <li><?= $title ?></li>
	    </ul>
	    <div class="grid sm:grid-cols-3 gap-5 mt-5">
	        <div class="card px-4 py-8 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
	            <div>
	                <span class="text-5xl leading-none las la-industry"></span>
	                <p class="mt-2">Moldeo</p>
	                <div class="text-primary mt-5 text-3xl leading-none">18</div>
	            </div>
	        </div>
	        <div class="card px-4 py-8 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
	            <div>
	                <span class="text-5xl leading-none las la-industry"></span>
	                <p class="mt-2">Ensamble</p>
	                <div class="text-primary mt-5 text-3xl leading-none">16</div>
	            </div>
	        </div>
	        <div class="card px-4 py-8 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
	            <div>
	                <span class="text-5xl leading-none las la-industry"></span>
	                <p class="mt-2">Planta 3</p>
	                <div class="text-primary mt-5 text-3xl leading-none">9</div>
	            </div>
	        </div>
	    </div>
	    <div class="card mt-5 p-5 min-w-0">
	        <h3>PLANNED INTERRUPTION</h3>
	        <div class="mt-5 min-w-0">
	            <canvas id="myChart" width="400" height="400"></canvas>
	        </div>
	    </div>
	</section>
	<script>
	    var data = [ 
	        {
	            value: 300,
	            color: "#F7464A",
	            highlight: "#FF5A5E",
	            label: "Red"
	        },
	        {
	            value: 50,
	            color: "#46BFBD",
	            highlight: "#5AD3D1",
	            label: "Green"
	        },
	        {
	            value: 100,
	            color: "#FDB45C",
	            highlight: "#FFC870",
	            label: "Yellow"
	        },
	        {
	            value: 40,
	            color: "#949FB1",
	            highlight: "#A8B3C5",
	            label: "Grey"
	        },
	        {
	            value: 120,
	            color: "#4D5360",
	            highlight: "#616774",
	            label: "Dark Grey"
	        }
	    ];
	    var ctx = document.getElementById("myChart").getContext("2d");
        console.log(ctx)
	    var myNewChart = new Chart(ctx).PolarArea(data);
	</script>