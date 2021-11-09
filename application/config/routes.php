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
$route['duplicateusername'] = 'user/check_duplicate_username';
$route['duplicatecmpy'] = 'user/check_duplicatecmpy';
$route['emailverify/(:any)'] = 'user/emailverify/$1';
$route['verifyemail/(:any)'] = 'user/emailverify/$1';


$route['websites'] = 'user/websites';
$route['addwebsites'] = 'user/addwebsites';


//users
$route['users'] = 'admin/users';

//users-sadmin
$route['newuser'] = 'admin/adduser_sadmin';


//users-cmpy
$route['adduser'] = 'admin/adduser_cmpy';
$route['userstatus'] = 'admin/change_userstatus';
$route['deleteuser'] = 'admin/admin_deleteuser';
$route['viewuser'] = 'admin/admin_viewuser';
$route['updateuserprofile'] = 'admin/admin_updateuserprofile';
$route['updateuserpwd'] = 'admin/admin_updateuserpwd';
$route['account-deactivate'] = 'admin/admin_deactivateaccount';
$route['activate-account'] = 'admin/admin_activateaccount';
$route['deactivate-sub'] = 'admin/admin_deactivatesub';
$route['activate-sub'] = 'admin/admin_activatesub';

$route['admin/users/(:any)'] = 'admin/users/$1';


$route['account'] = 'user/account';
$route['profile-edit'] = 'user/personal_edit';
$route['website-edit'] = 'user/edit_website';
$route['website-delete'] = 'user/delete_website';
$route['website-status'] = 'user/website_status';
$route['duplicate-webname'] = 'user/check_duplicate_webname';
$route['duplicate-weblink'] = 'user/check_duplicate_weblink';
$route['add-website'] = 'user/user_new_website';
$route['password-update'] = 'user/password_update';
$route['resetpassword_vcode'] = 'user/resetpassword_vcode';
$route['verify'] = 'user/verifyvcode';
$route['passwordreset'] = 'user/changepassword';
$route['deactivate-account'] = 'user/deact_account';


//rate
$route['wtr/(:any)'] = 'user/wtr/$1';


$route['logs'] = 'user/logs';


$route['getlink'] = 'user/getlink';
$route['share'] = 'user/sendlink';
$route['smsshare'] = 'user/sms_sendlink';
// $route['importcsv_sms'] = 'user/importcsv_sms';
// $route['importcsv_email'] = 'user/importcsv_email';
$route['smssample_csv'] = 'user/smssample_csv';
$route['emailsample_csv'] = 'user/emailsample_csv';
$route['sendmultiplesms'] = 'user/sendmultiplesms';
$route['sendmultipleemail'] = 'user/sendmultipleemail';


// $route['pgResponses'] = 'admin/pgResponses';
$route['plan'] = 'admin/pick_plan';


$route['payments'] = 'admin/payments';


$route['contact'] = 'admin/contact';
$route['feedbacks'] = 'admin/feedbacks';
$route['clearfeedbacks'] = 'admin/clearfeedbacks';
$route['activity'] = 'admin/logs';
$route['clearlogs'] = 'admin/clearlogs';


$route['logout'] = 'user/logout';


// $route['404_override'] = '';
$route['404_override'] = 'user/fof';
$route['translate_uri_dashes'] = FALSE;