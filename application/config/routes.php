<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

//default page
$route['default_controller'] = 'pages/view';


//posts, static pages
$route['posts'] = 'posts/index';

//assets machines

$route['machines'] = 'machines/index';
$route['machines/create'] = 'machines/create';
$route['machines/update'] = 'machines/update';
$route['machines/(:any)'] = 'machines/view/$1';
$route['machines/edit/(:any)'] = 'machines/edit/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//Plan
$route['planners'] = 'plan/index';

$route['api/plan/get_data'] = 'plan/api_get_data';


$route['api/plan/save']['post'] = 'plan/api_save_plan';
$route['planners/test'] = 'plan/test';
$route['cell'] = 'plan/select_cell';
$route['measuring_point'] = 'plan/select_measuring_point';
//assets
$route['assets'] = '/assets';
//plants
$route['plants'] = '/plants/index';
$route['plants/create'] = '/plants/create';
$route['plants/edit/(:any)'] = '/plants/edit/$1';
//sites
$route['sites'] = '/sites/index';
$route['sites/create'] = '/sites/create';
$route['sites/edit/(:any)'] = '/sites/edit/$1';
//machines
$route['machines'] = '/machines';
//andon
$route['andon_dashboard'] = 'andon/index';
//reports
$route['daily_report'] = 'reports/daily_report';
$route['custom_report'] = 'reports/custom_report';
$route['api/custom_report/save']['post'] = 'reports/save_custom_report';
//measuring_point
$route['measuring_point'] = '/measuring_point/index';
//manual_capture
$route['manual_capture'] = '/manual_capture/index';
$route['manual_capture/save']['post'] = '/manual_capture/save_manual_capture';
//trigger
$route['trigger'] = '/trigger/index';
//Output vs plan
$route['output_vs_plan/select_site'] = 'output_vs_plan/select_site';
$route['output_vs_plan'] = 'output_vs_plan/index';
$route['output_vs_plan/get_data'] = 'output_vs_plan/get_data';
//Interruption Cause
$route['api/interruption_cause/get'] = 'interruption_cause/api_get_plan';

$route['interruption_cause']['get'] = 'interruption_cause/index';
$route['interruption_cause']['post'] = 'interruption_cause/save';

$route['interruption_cause/cell'] = 'interruption_cause/select_cell';
$route['interruption_cause/measuring_point'] = 'interruption_cause/select_measuring';
//login
$route['login'] = '/login/verify_login';
$route['logout'] = '/login/logout';

//button_tablet
$route['manual_capture/button_tablet'] = '/manual_capture/tablet';
$route['api/manual_capture/save']['post'] = '/manual_capture/add_capture';
$route['api/manual_capture/modify']['post'] = '/manual_capture/modify_capture';
//select_plant_button
$route['manual_capture/select_plant_button'] = '/manual_capture/select_plant_button';
//$route['manual_capture/measuring_point_button'] = '/manual_capture/measuring_point_button';
//measuring_point_tablet
$route['manual_capture/measuring_point'] = '/manual_capture/measuring_point';
//test for Angular
$route['test/angular'] = 'testscontroller/test_angular';
$route['api/plants/all'] = 'plants/api_all';
$route['api/sites/all/(:num)'] = 'sites/api_all_by_plant/$1';
//error
$route['manual_capture/error'] = '/manual_capture/tablet';
