<?php
//if (!defined('_INCODE')) die('Access Deined...');
//File này chứa các hằng số cấu hình

date_default_timezone_set('Asia/Ho_Chi_Minh');

//Thiết lập hằng số cho client
const _MODULE_DEFAULT = 'auth'; //Module mặc định
const _ACTION_DEFAULT = 'login'; //Action mặc định
//
//Thiết lập hằng số cho admin
const _MODULE_DEFAULT_ADMIN = 'dashboard';

const _INCODE = true; //Ngăn chặn hành vi truy cập trực tiếp vào file

//Thiết lập host

define('_WEB_HOST_ROOT', 'http://'.$_SERVER['HTTP_HOST'].'/btl/Gym_manager_project/'); //Địa chỉ trang chủ

define('_WEB_HOST_TEMPLATE', _WEB_HOST_ROOT.'templates');

//Thiết lập path
define('_WEB_PATH_ROOT', __DIR__);
define('_WEB_PATH_TEMPLATE', _WEB_PATH_ROOT.'/templates');

//define('_WEB_HOST_TEMPLATE', _WEB_HOST_ROOT.'/templates/client');
//
define('_WEB_HOST_ROOT_ADMIN', _WEB_HOST_ROOT.'/admin');

define('_WEB_HOST_ADMIN_TEMPLATE', _WEB_HOST_ROOT.'templates/admin');

define('_WEB_HOST_ROOT_CLIENT', _WEB_HOST_ROOT.'/client');

define('_WEB_HOST_CLIENT_TEMPLATE', _WEB_HOST_ROOT.'templates/client');

//Thiết lập kết nối database

const _HOST = 'localhost';
const _USER = 'root';
const _PASS = ''; //Xampp => pass='';
const _DB = 'gym';
const _DRIVER = 'mysql';

//Thiết lập debug
const _DEBUG = true;

//Thiết lập số lượng bản ghi hiển thị trên 1 trang
const _PER_PAGE = 10;