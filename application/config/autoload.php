<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Drivers
| 4. Helper files
| 5. Custom config files
| 6. Language files
| 7. Models
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/
$autoload['packages'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in system/libraries/ or your
| application/libraries/ directory, with the addition of the
| 'database' library, which is somewhat of a special case.
|
| Prototype:
|
|	$autoload['libraries'] = array('database', 'email', 'session');
|
| You can also supply an alternative library name to be assigned
| in the controller:
|
|	$autoload['libraries'] = array('user_agent' => 'ua');
*/
$autoload['libraries'] = array(
	'database',
	'session',
	'util',
	'captcha',
	'email',
	'mail',
	'mail_tpl',
	'mail_booking_tpl',
	'paypal',
	'mobile_detect'
);

/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in system/libraries/ or in your
| application/libraries/ directory, but are also placed inside their
| own subdirectory and they extend the CI_Driver_Library class. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|	$autoload['drivers'] = array('cache');
|
| You can also supply an alternative property name to be assigned in
| the controller:
|
|	$autoload['drivers'] = array('cache' => 'cch');
|
*/
$autoload['drivers'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['helper'] = array('url', 'file');
*/
$autoload['helper'] = array('url', 'text');

/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/
$autoload['config'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/
$autoload['language'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['model'] = array('first_model', 'second_model');
|
| You can also supply an alternative model name to be assigned
| in the controller:
|
|	$autoload['model'] = array('first_model' => 'first');
*/
$autoload['model'] = array(
	'm_db',
	'm_arrival_port',
	'm_arrival_port_category',
	'm_booking_type',
	'm_car_fee',
	'm_category',
	'm_content',
	'm_country',
	'm_embassy',
	'm_fast_checkin_fee',
	'm_history',
	'm_holiday',
	'm_mail',
	'm_meta',
	'm_nation',
	'm_nation_type',
	'm_passport_type',
	'm_payment',
	'm_private_letter_fee',
	'm_processing_fee',
	'm_promotion',
	'm_province',
	'm_question',
	'm_redirect',
	'm_requirement',
	'm_review',
	'm_service_booking',
	'm_setting',
	'm_support_online',
	'm_tips',
	'm_user',
	'm_user_online',
	'm_visa_booking',
	'm_visa_fee',
	'm_visa_pax',
	'm_visa_type',
	'm_visit_purpose_types',
	'm_visit_purpose',
	'm_work_schedule',
	'm_review_audio',
	'm_cron_sendmail',
	'm_check_step',
	'm_comment',
	'm_agents',
	'm_agent_visa_fee',
	'm_agent_car_fee',
	'm_agent_private_letter_fee',
	'm_agent_fast_checkin_fee',
	'm_agent_processing_fee',
	'm_letter_log',
	'm_tour',
	'm_category_tour',
	'm_tour_fee',
	'm_tour_rate',
	'm_tour_booking',
	'm_car_plus_fee',
	'm_faqs',
	'm_faqs_category'
);
