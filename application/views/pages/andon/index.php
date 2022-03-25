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
	                    <span class="text-primary text-5xl leading-none las la-calendar-day"></span>
	                    <p class="mt-2">Today</p>
	                    <div class="text-primary mt-5 text-3xl leading-none">18</div>
	                </div>
	            </div>
	            <div class="card px-4 py-8 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
	                <div>
	                    <span class="text-primary text-5xl leading-none las la-clock"></span>
	                    <p class="mt-2">Pending</p>
	                    <div class="text-primary mt-5 text-3xl leading-none">16</div>
	                </div>
	            </div>
	            <div class="card px-4 py-8 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
	                <div>
	                    <span class="text-primary text-5xl leading-none las la-edit"></span>
	                    <p class="mt-2">Working</p>
	                    <div class="text-primary mt-5 text-3xl leading-none">9</div>
	                </div>
	            </div>
	        </div>
	        <!-- ANDON EVENT CHART -->
	        <div class="card p-5 min-w-0">
	            <h3>Andon Events for: Jan 05 2022</h3>
	            <div class="mt-5 min-w-0">
	                <canvas id="barChartWithShadow"></canvas>
	            </div>
	        </div>
	        <div class="grid sm:grid-cols-2 gap-5">
	            <!-- NEED SOLUTIONS -->
	            <div class="card p-5 flex flex-col">
	                <h3>Need Solutions</h3>
	                <table class="table table_list mt-3 w-full">
	                    <tbody>
	                        <tr>
	                            <td>
	                                <h5>Setup8 : Initial Break</h5>
	                                <small>47 dia(s), 22 hora(s), 46 minuto(s), 3 segundo(s) activo</small>
	                                <div class="grid sm:grid-cols-2 mt-3 gap-5">
	                                    <div>
	                                        <b>Plant:</b> Ensamble <br>
	                                        <b>Site: </b> Dilators <br>
	                                        <b>Machine</b>: BOY25 <br>
	                                        <b>Work Center:</b> BOY25
	                                    </div>
	                                    <div>
	                                        <b>Control no:</b> BOY25 <br>
	                                        <b>Part Number: </b> pn167 <br>
	                                        <b>Work Order</b>: on002 <br>
	                                    </div>
	                                </div>
	                            </td>
	                            <td class="text-center">
	                                <button type="button" class="btn btn_success uppercase">Success</button>
	                            </td>
	                        </tr>
	                        <tr>
	                            <td>
	                                <h5>Setup8 : Initial Break</h5>
	                                <small>47 dia(s), 22 hora(s), 46 minuto(s), 3 segundo(s) activo</small>
	                                <div class="grid sm:grid-cols-2 gap-5 mt-3">
	                                    <div>
	                                        <b>Plant:</b> Ensamble <br>
	                                        <b>Site: </b> Dilators <br>
	                                        <b>Machine</b>: BOY25 <br>
	                                        <b>Work Center:</b> BOY25
	                                    </div>
	                                    <div>
	                                        <b>Control no:</b> BOY25 <br>
	                                        <b>Part Number: </b> pn167 <br>
	                                        <b>Work Order</b>: on002 <br>
	                                    </div>
	                                </div>
	                            </td>
	                            <td class="text-center">
	                                <button type="button" class="btn btn_success uppercase">Success</button>
	                            </td>
	                        </tr>
	                    </tbody>
	                </table>
	            </div>
	            <!-- Need Attention -->
	            <div class="card p-5 flex flex-col">
	                <h3>Need Attention</h3>
	                <table class="table table_list mt-3 w-full">
	                    <tbody>
	                        <tr>
	                            <td>
	                                <h5>Setup8 : Initial Break</h5>
	                                <small>47 dia(s), 22 hora(s), 46 minuto(s), 3 segundo(s) activo</small>
	                                <div class="grid sm:grid-cols-2 mt-3 gap-5">
	                                    <div>
	                                        <b>Plant:</b> Ensamble <br>
	                                        <b>Site: </b> Dilators <br>
	                                        <b>Machine</b>: BOY25 <br>
	                                        <b>Work Center:</b> BOY25
	                                    </div>
	                                    <div>
	                                        <b>Control no:</b> BOY25 <br>
	                                        <b>Part Number: </b> pn167 <br>
	                                        <b>Work Order</b>: on002 <br>
	                                    </div>
	                                </div>
	                            </td>
	                            <td class="text-center">
	                                <button type="button" class="btn btn_danger uppercase">Attend</button>
	                            </td>
	                        </tr>
	                        <tr>
	                            <td>
	                                <h5>Setup8 : Initial Break</h5>
	                                <small>47 dia(s), 22 hora(s), 46 minuto(s), 3 segundo(s) activo</small>
	                                <div class="grid sm:grid-cols-2 mt-3 gap-5">
	                                    <div>
	                                        <b>Plant:</b> Ensamble <br>
	                                        <b>Site: </b> Dilators <br>
	                                        <b>Machine</b>: BOY25 <br>
	                                        <b>Work Center:</b> BOY25
	                                    </div>
	                                    <div>
	                                        <b>Control no:</b> BOY25 <br>
	                                        <b>Part Number: </b> pn167 <br>
	                                        <b>Work Order</b>: on002 <br>
	                                    </div>
	                                </div>
	                            </td>
	                            <td class="text-center">
	                                <button type="button" class="btn btn_danger uppercase">Attend</button>
	                            </td>
	                        </tr>
	                    </tbody>
	                </table>
	            </div>
	        </div>
	</section>
	<script src="<?php echo  base_url() ?>assets/js/chart.min.js"></script>