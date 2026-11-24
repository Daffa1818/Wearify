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
$route['default_controller'] = 'Admin/Dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['gudang'] = 'Gudang/index';
$route['gudang/proses_login'] = 'Gudang/proses_login';
$route['gudang/dashboard'] = 'Gudang/dashboard';
$route['gudang/persediaan'] = 'Gudang/persediaan';
$route['gudang/tambah-barang'] = 'Gudang/tambah_barang';
$route['gudang/simpan-barang'] = 'Gudang/simpan_barang';
$route['gudang/edit-barang/(:num)'] = 'Gudang/edit_barang/$1';
$route['gudang/update-barang/(:num)'] = 'Gudang/update_barang/$1';
$route['gudang/hapus-barang/(:num)'] = 'Gudang/hapus_barang/$1';
$route['gudang/barang-masuk'] = 'Gudang/barang_masuk';
$route['gudang/simpan_barang_masuk'] = 'Gudang/simpan_barang_masuk';
$route['gudang/edit_barang_masuk/(:num)'] = 'Gudang/edit_barang_masuk/$1';
$route['gudang/update_barang_masuk/(:num)'] = 'Gudang/update_barang_masuk/$1';
$route['gudang/hapus_barang_masuk/(:num)'] = 'Gudang/hapus_barang_masuk/$1';
$route['gudang/barang-keluar'] = 'Gudang/barang_keluar';
$route['gudang/simpan_barang_keluar'] = 'Gudang/simpan_barang_keluar';
$route['gudang/edit_barang_keluar/(:num)'] = 'Gudang/edit_barang_keluar/$1';
$route['gudang/update_barang_keluar/(:num)'] = 'Gudang/update_barang_keluar/$1';
$route['gudang/hapus_barang_keluar/(:num)'] = 'Gudang/hapus_barang_keluar/$1';
$route['gudang/logout'] = 'Gudang/logout';
