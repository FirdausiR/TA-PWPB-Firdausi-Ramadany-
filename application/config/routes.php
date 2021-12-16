<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'init';

$route['admin/p/(:any)'] = "admin/load/pages/$1";

$route['404_override'] = 'init/page_not_found';
$route['translate_uri_dashes'] = FALSE;
