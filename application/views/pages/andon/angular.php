	<!-- Breadcrumb -->
	<section class="breadcrumb" ng-app='myapp' >
		<h1><?= $title ?></h1>
		<ul>
			<li><a href="#">Pages</a></li>
			<li class="divider la la-arrow-right"></li>
			<li><?= $title ?></li>
		</ul>


		<div ng-controller='userCtrl'>
		<label for="plants">Choose a plant:</label>

		<select ng-options="p.plant_id as p.plant_name for p in plants"
		 ng-model="selected_plant" ng-change="change_plant()" ></select>	
		

		 <select ng-options="p.site_id as s.site_name for s in sites"
		 ng-model="selected_site" ng-change="change_site()" ></select>
		 
		</div>
		

	</section>

	<script>
 var fetch = angular.module('myapp', []);

 fetch.controller('userCtrl', ['$scope', '$http', function ($scope, $http) {
 
	$scope.plants = [];
	$scope.selected_plant = null;

	$scope.sites = [];
	$scope.selected_site = null;

   $scope.init = function()
   {
	   $scope.getPlants();
   }

   $scope.getPlants = function(){
    $http({
     method: 'get',
     url: '<?= base_url() ?>index.php/api/plants/all'
    }).then(function successCallback(response) {
      
	   // Assign response to users object
    	$scope.plants = response.data;
		console.log($scope.plants);
    }); 
   }

   $scope.change_plant = function()
   {
	   console.log('changed..' + $scope.selected_plant);
	   $scope.getSites();
	}

   $scope.getSites = function(){
    $http({
     method: 'get',
     url: '<?= base_url() ?>index.php/api/sites/all/' + $scope.selected_plant
    }).then(function successCallback(response) {
      
	   // Assign response to users object
    	$scope.sites = response.data;
		console.log($scope.plants);
    }); 
   }

   $scope.change_site = function()
   {
	   console.log('changed..' + $scope.selected_site);
   }

	//este es al cargar
   $scope.init();
 }]);

 </script>