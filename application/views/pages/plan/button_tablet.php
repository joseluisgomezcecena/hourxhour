<style>
    input{
        border: transparent;
        background-color: transparent;
    }
</style>
<div class="flex justify-between mb-5" style="margin-top: -4rem;">
<span class="brand">
    <img width="150" src="<?php echo base_url(); ?>assets/images/transparente.png" alt="">
</span>
</div>
<div class="card w-50 text-center">
    <div class="container mt-5">
        <p>Item number:</p>
        <h1 class="text-primary mb-8"><b>AC1043M-6ST</b></h1>
        <div class="alert alert_outlined alert_success my-5">
                    Agrega nueva captura en el campo color verde! No olvides guardar la nueva captura agregada.
                    <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
                </div>
        <div class="mt-5 mb-5">
            <input type="text" class="form-control" disabled style="width: 4rem;"> / <span class="h3">500</span>
        </div>
        <div>
            <button class="btn btn_warning" style="width: 15em; margin:auto; display:block;">Capturar</button>
        </div>
        <div class="flex  justify-end mt-8">
            <div class="">
                <label class="switch">
                    <input type="checkbox">
                    <span></span>
                    <span>Modificar captura</span>
                </label>
                <button class="btn btn_success mt-4" disabled>Guardar nueva captura</button>
            </div>
        </div>
        <div class="flex flex justify-between mt-5 mb-5">
           <div>
           <label class="custom-checkbox">
                    <input type="checkbox" checked="">
                    <span></span>
                    <span>Finalizar proceso de captura</span>
                </label>
           </div>
                <button class="btn btn_danger" disabled>Finalizar Captura</button>
    
        </div>
    </div>
</div>