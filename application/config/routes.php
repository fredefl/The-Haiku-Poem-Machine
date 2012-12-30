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
if ((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
	$route["poem/save/(:any)"] = "api/save/$1";
	$route["poem/(:any)"] = "api/poem/$1";
	$route["live"] = "api/live";
	$route["live/(:any)"] = "api/live/$1";
	$route["select/(:any)"] = "api/select/$1";
	$route["collections"] = "api/GetCollections";
	$route["tags"] = "api/GetTags";
	$route["collection/create"] = "api/CreateCollection";
	$route["tag/(:num)"] = "api/GetPoemByIdTag/$1";
	$route["tag/(:any)"] = "api/GetPoemByStringTag/$1";
} else {
	$route["poem/(:any)"] = "ui/viewpoem/$1";
	$route["collections"] = "ui/collections";
	$route["collection/create"] = "ui/CreateCollection";
	$route["tag/(:any)"] = "ui/PoemsByTag/$1";
}

$route["collection/(:any)"] = "api/collection/$1";

$route["(:any)/view"] = "ui/viewcollection/$1";
$route["(:any)/save"] = "api/createpoemcollection/$1";
$route["(:any)"] = "ui/createpoemcollection/$1";

$route['default_controller'] = "ui/home";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */