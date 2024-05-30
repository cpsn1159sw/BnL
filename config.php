<?php
const _MODULE = 'public';
const _ACTION = 'home';
const _CODE = true;

// Thiết lập host 
define('_WEB_HOST', 'http://' . $_SERVER['HTTP_HOST'] . '/BnL');
define('_WEB_HOST_TEMPLATES', _WEB_HOST . '/templates');

// http://localhost:88/BnL/templates/

// Thiết lập path
define('_WEB_PATH', __DIR__);
define('_WEB_PATH_TEMPLATES', _WEB_PATH . '/templates');

// Thông tin kết nối 
const _HOST = 'localhost';
const _DB = 'db_shop';
const _USER = 'root';
const _PASS = '';
?>
