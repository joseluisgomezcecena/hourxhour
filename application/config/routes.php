<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['posts'] = 'posts/index';
$route['machines'] = 'machines/index';
$route['machines/create'] = 'machines/create';
$route['default_controller'] = 'pages/view';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Plan
$route['planners'] = 'plan/index';
$route['planners/test'] = 'plan/test';
$route['cell'] = 'plan/select_cell';
$route['measuring_point'] = 'plan/select_measuring_point';
//assets
$route['assets'] = '/assets';
//plants
$route['plants'] = '/plants';
//sites
$route['sites'] = '/sites';
//machines
$route['machines'] = '/machines';
//andon
$route['andon_dashboard'] = 'andon/index';
//daily_report
$route['daily_report'] = '/reports/index';
//measuring_point
$route['measuring_point'] = '/measuring_point/index';
//manual_capture
$route['manual_capture'] = '/manual_capture/index';


$route['test/plant/'] = 'testscontroller/plant_index';
$route['test/plant/show'] = 'testscontroller/plant_show';
$route['test/plant/create'] = 'testscontroller/plant_create';
$route['test/plant/update'] = 'testscontroller/plant_update';
$route['test/plant/delete'] = 'testscontroller/plant_delete';

//test for Angular
$route['test/angular'] = 'testscontroller/test_angular';
$route['api/plants/all'] = 'plants/api_all';
$route['api/sites/all/(:num)'] = 'sites/api_all_by_plant/$1';
