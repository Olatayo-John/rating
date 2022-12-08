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

//creating web after reg
$route['platform'] = 'user/platform';
$route['get-user-quota'] = 'user/get_userQuota';
$route['add-website'] = 'user/addwebsite';
$route['remove-website'] = 'user/removewebsite';
//


//Admins- [sadmin ,admin]
$route['users'] = 'admin/users';
$route['add'] = 'admin/add';
$route['user-subscription'] = 'admin/user_sub';
$route['update-profile'] = 'admin/updateprofile';
$route['update-user-company'] = 'admin/updatecompany';
$route['update-user-quota'] = 'admin/updatequota';
$route['deactivate-user-account'] = 'admin/deactivateaccount';
$route['activate-user-account'] = 'admin/activateaccount';
$route['deactivate-user-sub'] = 'admin/deactivatesub';
$route['activate-user-sub'] = 'admin/activatesub';
$route['update-user-password'] = 'admin/updatepassword';

//SAdmin
$route['sadmin-add-user'] = 'admin/adduser_sadmin';
$route['sadmin-view-user'] = 'admin/viewuser_sadmin';

$route['plans'] = 'admin/plans';
$route['get-plan'] = 'admin/getplan';
$route['update-plan'] = 'admin/updateplan';
$route['add-plan'] = 'admin/addplan';

//payments
$route['payment-response'] = 'admin/paymentResponse';
$route['payments'] = 'admin/payments';
$route['get-payment-details'] = 'admin/get_paymentsDetails';

$route['feedbacks'] = 'admin/feedbacks';
$route['clear-feedbacks'] = 'admin/clearfeedbacks';
$route['activity'] = 'admin/logs';
$route['clear-activity-logs'] = 'admin/clearlogs';


//settings
$route['settings'] = 'settings/index';
$route['save-settings'] = 'settings/save';



//companyAdmin
$route['admin-add-user'] = 'admin/adduser_admin';
$route['admin-view-user'] = 'admin/viewuser_admin';


//user-account
// $route['account'] = 'user/account';
$route['account'] = 'user/account_edit';
$route['account-edit'] = 'user/account_edit';
$route['company-edit'] = 'user/company_edit';
$route['profile-edit'] = 'user/personal_edit';
$route['website-edit'] = 'user/edit_website';
// $route['website-delete'] = 'user/delete_website';
$route['update-website'] = 'user/website_update';
$route['duplicate-webname'] = 'user/check_duplicate_webname';
$route['duplicate-weblink'] = 'user/check_duplicate_weblink';
$route['create-website'] = 'user/createwebsite';
$route['password-update'] = 'user/password_update';
$route['resetpassword_vcode'] = 'user/resetpassword_vcode';
$route['verify'] = 'user/verifyvcode';
$route['passwordreset'] = 'user/changepassword';
$route['deactivate-account'] = 'user/deact_account';


//rating and links-shared logs
$route['logs'] = 'user/logs';


//share
$route['getlink'] = 'user/getlink';
$route['get-platform-link'] = 'user/getPlatformLink';
$route['share'] = 'user/sendlink';

$route['sms-sample-csv'] = 'user/smssample_csv';
$route['email-sample-csv'] = 'user/emailsample_csv';

$route['share-email'] = 'user/email_share';
$route['share-sms'] = 'user/sms_share';
$route['share-whatsapp'] = 'user/whatsapp_share';

$route['import-csv-email'] = 'user/importcsv_email';
$route['import-csv-sms'] = 'user/importcsv_sms';

$route['share-email-multiple'] = 'user/sendmultipleemail';
$route['share-sms-multiple'] = 'user/sendmultiplesms';


//rate
// $route['wtr/(:any)'] = 'user/wtr/$1';
$route['wtr/(:any)'] = 'rate/index/$1';
$route['wtr/(:any)/(:num)'] = 'rate/index/$1/$2';
$route['save-rating'] = 'rate/saveRating';



$route['support'] = 'admin/support';
$route['logout'] = 'user/logout';


//testCase
$route['testCase'] = 'admin/testCase';


// $route['404_override'] = '';
$route['404_override'] = 'user/fof';
$route['translate_uri_dashes'] = FALSE;
