<style>
    input {
        border: transparent;
        background-color: transparent;
    }
</style>
<div class="flex justify-between mb-5" style="margin-top: -4rem;">
    <span class="brand">
        <img width="150" src="<?php echo base_url(); ?>assets/images/transparente.png" alt="">
    </span>
</div>
<div class="card w-50 text-center" ng-model="production_plan.shift_id" ng-controller="buttonController" ng-app="buttonApp">
    <div class="container mt-5">
        <p>Item number:</p>
        <h1 class="text-primary mb-8"><b><?= $item_number ?></b></h1>
        <div class="alert alert_success my-5" ng-if="!IsDisabledButtonModify">
            <strong class="uppercase"><bdi>Agrega nueva captura en el campo color verde!<br /></bdi></strong>
            No olvides guardar la nueva captura agregada.
        </div>
        <div class="mt-5 mb-5">
            <input type="text" ng-style="!IsDisabledButtonModify && {'background-color':'#b8d5cd'}" class="form-control h3" ng-disabled="IsDisabledButtonModify" style="width: 4.5rem; text-align: right !important;"> / <span class="h3" style="margin-left: 1rem !important;"><?= $planned ?></span>
        </div>
        <div>
            <button class="btn btn_warning" style="width: 15em; margin:auto; display:block;" ng-click="capture()" ng-disabled="!IsDisabledButtonModify">Capturar</button>
        </div>
        <div class="flex  justify-end mt-8">
            <div>
                <label class="switch">
                    <input type="checkbox" ng-model="isModify" ng-change="EnableDisableButtonModify()">
                    <span></span>
                    <span>Modificar captura</span>
                </label>
                <button ng-disabled="IsDisabledButtonModify" class="btn btn_success mt-4">Guardar nueva captura</button>
            </div>
        </div>
        <div class="flex flex justify-between mt-5 mb-5">
            <button class="btn btn_danger" ng-click="isFinished()">Finalizar Captura</button>
        </div>
    </div>
</div>
<script>
    var fetch = angular.module('buttonApp', []);
    fetch.controller('buttonController', ['$scope', '$http', function($scope, $http) {

        $scope.IsDisabledButtonModify = true;

        $scope.EnableDisableButtonModify = function() {
            $scope.IsDisabledButtonModify = !$scope.isModify;
        };

        $scope.capture = function() {
            var url = '<?= base_url() ?>api/manual_capture/save';
            var params = {
                plan_by_hour_id: <?= $plan_by_hour_id ?>,
                reset: false,
                capture_type: 0
            }
            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }
            $http({
                url: url,
                method: "POST",
                params: params
            }).then(function(response) {
                console.log(response);
                swal("Good job!", "The plan has been saved.", "success");
            }, function(response) {
                console.log({
                    response
                });
            });
        };

        $scope.isFinished = function() {
            swal({
                    title: "Are you sure?",
                    text: "Once finished, you will not be able to recover this Item!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Your Item has been deleted!", {
                            icon: "success",
                        });
                        setTimeout(() => {
                            window.location = "<?php echo base_url(); ?>/manual_capture/select_plant_button";
                        }, 1600);
                    } else {
                        swal.close();
                    }
                });
        };
    }]);
</script>