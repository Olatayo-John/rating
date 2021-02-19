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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'user';
$route['/'] = 'user/index';

$route['login'] = 'user/login';
$route['register'] = 'user/register';
$route['emailverify/(:any)'] = 'user/emailverify/$1';


$route['websites'] = 'user/websites';
$route['profile'] = 'user/profile';
$route['share'] = 'user/sendlink';
$route['account'] = 'user/account';
$route['plan'] = 'admin/pick_plan';
$route['contact'] = 'user/contact';
$route['feedbacks'] = 'user/feedbacks';
$route['payments'] = 'admin/payments';

// $route['pgResponses'] = 'admin/pgResponses';

$route['logout'] = 'user/logout';

//users
$route['users'] = 'admin/users';
$route['wtr/(:any)'] = 'user/wtr/$1';
$route['admin/users/(:any)'] = 'admin/users/$1';
$route['admin/votes/(:any)'] = 'admin/votes/$1';

//votes
$route['votes'] = 'admin/votes';

$route['404_override'] = 'user/fof_error';
$route['translate_uri_dashes'] = FALSE;
