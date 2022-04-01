 <!-- Brand -->
 <span class="brand" style="margin-top: -6.5rem;">
     <img width="150" src="<?php echo base_url(); ?>assets/images/transparente.png" alt="">
 </span>
 <!-- Breadcrumb -->
 <section class="breadcrumb">
     <h1><?= $title ?></h1>
     <ul>
         <li><a href="#">Pages</a></li>
         <li class="divider la la-arrow-right"></li>
         <li><?= $title ?></li>
     </ul>
     <div class="grid lg:grid-cols-4 gap-5 p-5">
         <a href="<?php echo base_url(); ?>manual_capture/button_tablet">
             <div class="card p-5">
                 <div class="items-center px-5 py-2">
                     <h5 class="mb-0 uppercase">TIP32</h5>
                     <small>Selet this point</small>
                 </div>
             </div>
         </a>
         <!--<a href="<?php echo base_url(); ?>manual_capture/button_tablet">
             <div class="card p-5">
                 <div class="items-center px-5 py-2">
                     <h5 class="mb-0 uppercase">TIP32</h5>
                     <small>Selet this point</small><br>
                     <small class="text-primary"><span class="icon las la-exclamation-triangle mt-3"></span>Ya existe un plan para este dia</small>
                 </div>
             </div>
         </a>-->
     </div>
 </section>