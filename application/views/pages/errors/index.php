<div class="d-flex justify-content-center" style="margin-top: 3rem;">
    <div class="card w-75 p-3">
        <span class="brand d-flex justify-content-center my-3">
            <img width="200" src="<?php echo base_url(); ?>assets/images/transparente.png" alt="">
        </span>

        <div class="card-body">
            <h4 class="text-center">
                <?php echo $title; ?>
            </h4>

            <h3 class="text-center">
                <?php echo $message; ?>
            </h3>

            <div class="row">
                <div class="col"></div>
                <div class="col-auto">
                    <a href="<?php echo $url; ?>" class="btn btn-primary text-end">
                        Regresar
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>