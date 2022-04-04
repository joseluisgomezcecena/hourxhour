<style>
    input {
        border: transparent;
        background-color: transparent;
    }
</style>
<?= $now_date ?>
<div class="flex justify-between mb-5" style="margin-top: -4rem;">
    <span class="brand">
        <img width="150" src="<?php echo base_url(); ?>assets/images/transparente.png" alt="">
    </span>
</div>
<?= json_encode($plan)?>
<div class="card w-50 text-center" ng-controller="buttonController" ng-app="buttonApp">
    <div class="container mt-5">
        <p>Item number:</p>
        <h1 class="text-primary mb-8"><b>AC1043M-6ST</b></h1>
        <div class="alert alert_success my-5" ng-if="!IsDisabledButtonModify">
                    <strong class="uppercase"><bdi>Agrega nueva captura en el campo color verde!<br/></bdi></strong>
                    No olvides guardar la nueva captura agregada.
                </div>
        <div class="mt-5 mb-5">
            <input type="text" ng-style="!IsDisabledButtonModify && {'background-color':'#b8d5cd'}" class="form-control h3" ng-disabled="IsDisabledButtonModify"  style="width: 4.5rem; text-align: right !important;"> / <span class="h3" style="margin-left: 1rem !important;" >500</span>
        </div>
        <div>
            <button class="btn btn_warning" style="width: 15em; margin:auto; display:block;" ng-disabled="!IsDisabledButtonModify">Capturar</button>
        </div>
        <div class="flex  justify-end mt-8">
            <div class="">
                <label class="switch">
                    <input type="checkbox" ng-model="isModify" ng-change="EnableDisableButtonModify()">
                    <span></span>
                    <span>Modificar captura</span>
                </label>
                <button ng-disabled="IsDisabledButtonModify" class="btn btn_success mt-4">Guardar nueva captura</button>
            </div>
        </div>
        <div class="flex flex justify-between mt-5 mb-5">
            <div>
                <label class="custom-checkbox">
                    <input type="checkbox" ng-model="isFinished" ng-change="EnableDisableButtonFinish()">
                    <span></span>
                    <span>Finalizar proceso de captura</span>
                </label>
            </div>
            <button class="btn btn_danger" ng-disabled="IsDisabledButtonFinish">Finalizar Captura</button>
        </div>
    </div>
</div>
<script>
    angular.module("buttonApp", [])
        .controller("buttonController", function($scope, $compile) {

            $scope.IsDisabledButtonFinish = true;
            $scope.IsDisabledButtonModify = true;

            $scope.EnableDisableButtonFinish = function () {
                //If Button is disabled it will be enabled and vice versa.
                $scope.IsDisabledButtonFinish = !$scope.isFinished;
            }
            $scope.EnableDisableButtonModify = function () {
                //If Button is disabled it will be enabled and vice versa.
                $scope.IsDisabledButtonModify = !$scope.isModify;
            }
            $scope.modifyCapture = function() {
                console.log("adentro");
            };
        });
</script>