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

| When you set this option to TRUE, it will replace ALL dashes with

| underscores in the controller and method URI segments.

|

| Examples:	my-controller/index	-> my_controller/index

|		my-controller/my-method	-> my_controller/my_method

*/

$route['default_controller'] = "Index";
/*$route['default_controller'] = "admin/Dashboard/index";*/

$route['404_override'] = 'admin/Dashboard/pageNotFound';

$route['translate_uri_dashes'] = FALSE;





// Front 

$route['privacy-policy']  = 'privacy_policy';

$route['refund-policy'] = 'refund_policy';

$route['terms-of-use'] = 'terms_of_use';

$route['cookies-policy'] = 'cookies_policy';
$route['contact-us'] = 'contact';

$route['driver-installation-instruction'] = 'driver_installation_instruction';
$route['trial-driver-download'] = 'driver_installation_instruction/downloadlink';
$route['try-now'] = 'driver_installation_instruction/trynow';

$route['after-install'] = 'after_install';

$route['after-uninstall'] = 'after_uninstall';

$route['uninstall/feedback'] = 'feedback';//'uninstallinstructions';    //'feedback';

$route['installed/welcome'] = '';

$route['buy-now'] = 'cart';



//$route['front/login/resetPasswordConfirmUser/(:any)'] = 'front/login/resetPasswordConfirmUser/$1';

$route['admin'] = 'admin/dashboard';
//booking routs
$route['admin/bookings/(:num)/status'] 	= 'admin/bookings/change_booking_status/$1';
$route['admin/bookings/(:num)/logs'] 	= 'admin/bookings/booking_logs/$1';
$route['admin/bookings/(:num)/edit'] 	= 'admin/bookings/edit/$1';
$route['admin/bookings/(:num)/add_payment'] 	= 'admin/bookings/add_payment/$1';
$route['admin/bookings/(:num)/add_refund'] 	= 'admin/bookings/add_refund/$1';
$route['admin/bookings/(:num)/delete_payment/(:num)'] 	= 'admin/bookings/delete_payment/$1/$2';
$route['admin/bookings/(:num)/cancel_status'] 	= 'admin/bookings/cancel_status/$1';
$route['admin/bookings/(:num)/edit_payment'] 	= 'admin/bookings/edit_payment/$1';
$route['admin/consultants/(:num)/edit'] 	= 'admin/consultants/edit/$1';
$route['admin/sales/(:num)/edit'] 	= 'admin/sales/edit/$1';
$route['admin/sales/(:num)/add_payment'] 	= 'admin/sales/add_payment/$1';
$route['admin/sales/(:num)/add_refund'] 	= 'admin/sales/add_refund/$1';
$route['admin/sales/(:num)/edit_payment'] 	= 'admin/sales/edit_payment/$1';
$route['admin/sales/(:num)/delete_payment/(:num)'] 	= 'admin/sales/delete_payment/$1/$2';
$route['admin/harvesting_management'] 	= 'admin/bookings/harvesting';
$route['admin/delivery_management'] 	= 'admin/bookings/delivery';
 

$route['user'] 	= 'user/dashboard';
$route['vendor']= 'vendor/dashboard';



// Service supp

$route['product/(:num)/(:num)'] = 'product_list/get_product_list/$1/$1';

$route['shop'] = 'product_list/get_product_list';



$route['time-closed'] = 'timeclosed';

