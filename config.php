<?php
    const _MODULE = 'home';
    const _ACTION = 'dashboard';
    const _CODE = 'true';

    // thiết lập host 
    define('_WEB_HOST', 'http://'. $_SERVER['HTTP_HOST']. '/Project1');
    define('_WEB_HOST_TEMPLATES', _WEB_HOST. '/templates');

    // thiết lập path
    define('_WEB_PATH', __DIR__);
    define('_WEB_PATH_TEMPLATES', _WEB_PATH. '/templates');

    // thông tin kết nối 
    const _HOST = 'localhost';
    const _DB = 'database';
    const _USER = 'root';
    const _PASS = '';