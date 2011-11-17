<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "news";
$route['404_override'] = 'notfound';

$route['en/projects/(:num)'] = "projects/show/$1";
$route['projects/(:num)'] = "projects/show/$1";

$route['en/directions/(:num)'] = "directions/show/$1";
$route['directions/(:num)'] = "directions/show/$1";

$route['en/users/(:num)'] = "users/show/$1";
$route['users/(:num)'] = "users/show/$1";
$route['en/users/(:num)/(:any)'] = "users/show/$1/$2";
$route['users/(:num)/(:any)'] = "users/show/$1/$2";

$route['en/publications/(:num)'] = "publications/index/$1";
$route['publications/(:num)'] = "publications/index/$1";
// @todo переделать, если кто придумает как

$route['en/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = "$2/$3/$4/$5/$6/$7";
$route['en/(:any)/(:any)/(:any)/(:any)/(:any)'] = "$2/$3/$4/$5/$6"; // Язык всегда первый параметр метода
$route['en/(:any)/(:any)/(:any)/(:any)'] = "$2/$3/$4/$5"; // Язык всегда первый параметр метода
$route['en/(:any)/(:any)/(:any)'] = "$1/$2/$3"; // Язык всегда первый параметр метода
$route['en/(:any)/(:any)'] = "$2/$3"; // Язык всегда первый параметр метода
$route['(en)/(:any)'] = "$2"; // Язык всегда первый параметр метода
$route['en'] = "/news"; // Язык всегда первый параметр метода

//$route['(:any)/(:any)/(.*)'] = "$2/$1/$3";
//$route['(:any)/(:any)'] = "$2/$1";


/* End of file routes.php */
/* Location: ./application/config/routes.php */