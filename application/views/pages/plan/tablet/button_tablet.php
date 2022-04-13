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
<div class="card w-50 text-center" ng-controller="buttonController" ng-app="buttonApp">
    <div class="container mt-5">
        <div class="alert alert_danger my-5" ng-hide="verified">
            <strong class="uppercase"><bdi>There is no item number.<br /></bdi></strong>
            contact your supervisor
        </div>
        <div ng-show="verified">
            <p>Item number:</p>
            <h1 class="text-primary mb-8"><b><?= $item_number ?></b></h1>
            <div class="alert alert_success my-5" ng-if="!IsDisabledButtonModify">
                <strong class="uppercase"><bdi>Add new capture in the green field!<br /></bdi></strong>
                Don't forget to save the new capture added.
            </div>
            <div class="mt-5 mb-5">
                <input ng-model="completed" type="text" ng-style="!IsDisabledButtonModify && {'background-color':'#b8d5cd'}" class="form-control h3" ng-disabled="IsDisabledButtonModify" style="width: 4.5rem; text-align: right !important;"> / <span class="h3" style="margin-left: 1rem !important;"><?= $planned ?></span>
            </div>
            <div>
                <button class="btn btn_warning" style="width: 15em; margin:auto; display:block;" ng-click="capture()" ng-disabled="!IsDisabledButtonModify">Capture</button>
            </div>
            <div class="flex  justify-end mt-8">
                <div>
                    <label class="switch">
                        <input type="checkbox" ng-model="isModify" ng-change="EnableDisableButtonModify()">
                        <span></span>
                        <span>Modify capture</span>
                    </label>
                    <button ng-disabled="IsDisabledButtonModify" ng-click="modify_item()" class="btn btn_success mt-4">Save new capture</button>
                </div>
            </div>
            <div class="flex flex justify-between mt-5 mb-5">
                <button class="btn btn_danger" ng-click="isFinished()">Finish capture</button>
            </div>
        </div>
    </div>
</div>
<script>
    var fetch = angular.module('buttonApp', []);
    fetch.controller('buttonController', ['$scope', '$http', '$httpParamSerializerJQLike', function($scope, $http, $httpParamSerializerJQLike) {

        $scope.IsDisabledButtonModify = true;
        $scope.verified = true;
        $scope.completed = <?= $completed ?>;

        $scope.isVerify = function() {
            var item_id = '<?= $item_id ?>';

            if (item_id == '') {
                $scope.verified = false;
            } else {
                $scope.verified = true;
            }
        };

        $scope.EnableDisableButtonModify = function() {
            $scope.IsDisabledButtonModify = !$scope.isModify;
        };

        $scope.capture = function() {
            var url = '<?= base_url() ?>api/manual_capture/save';
            var params = {
                plan_by_hour_id: <?= $plan_by_hour_id ?>,
                reset: 0,
                capture_type: <?= CAPTURE_BUTTON ?>
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
                $scope.completed = response.data.completed;
            }, function(response) {
                swal("Something was wrong!", '', "error");
            });
        };

        $scope.modify_item = function() {
            var data = {
                value: $scope.completed,
                plan_by_hour_id: <?= $plan_by_hour_id ?>,
                reset: 1,
                capture_type: <?= CAPTURE_BUTTON ?>
            };
            $http({
                url: '<?= base_url() ?>api/manual_capture/modify',
                method: 'POST',
                data: $httpParamSerializerJQLike(data), // Make sure to inject the service you choose to the controller
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' // Note the appropriate header
                }
            }).then(function(response) {
                $scope.IsDisabledButtonModify = true;
                /* do something here */
            }).catch((error) => {
                console.log(error);
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
        $scope.isVerify();
    }]);
</script>