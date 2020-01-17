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
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = 'error404';
$route['translate_uri_dashes'] = TRUE;
$route['download-visa-application-forms'] = "downloads";
$route['visa-fee/(:any)'] = "visa_fee/index/$1";
$route['legal/(:any)'] = "legal/index/$1";
$route['news/travel/view/(:any)'] = "news/travel/$1";
$route['news/travel/(:any)'] = "news/travel/$1";
$route['news/travel'] = "news/travel";
$route['news/view/(:any)'] = "news/index/$1";
$route['news/(:any)'] = "news/index/$1";
$route['faqs/view/(:any)'] = "faqs/index/$1";
$route['faqs/(:any)'] = "faqs/index/$1";
$route['services/view/(:any)'] = "services/index/$1";
$route['services/(:any)'] = "services/index/$1";
$route['vietnam-embassies/view/(:any)'] = "vietnam-embassies/index/$1";
$route['vietnam-embassies/(:any)'] = "vietnam-embassies/index/$1";
$route['vietnam-visa-tips/view/(:any)'] = "vietnam-visa-tips/index/$1";
$route['vietnam-visa-tips/(:any)'] = "vietnam-visa-tips/index/$1";
$route['visa-requirements/view/(:any)'] = "visa-requirements/index/$1";
$route['visa-requirements/(:any)'] = "visa-requirements/index/$1";
$route['tours'] = "tours/index";
$route['tours/failure'] = "tours/failure";
$route['tours/success'] = "tours/success";
$route['tours/review'] = "tours/booking_review";
$route['tours/checkout'] = "tours/booking-checkout";
$route['tours/ajax-api'] = "tours/ajax_api";
$route['tours/login'] = "tours/login";
$route['tours/(:any)'] = "tours/index/$1";
$route['tours/(:any)/(:any)'] = "tours/index/$1/$2";
