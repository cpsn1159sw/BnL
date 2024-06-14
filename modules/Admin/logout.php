<!-- Đăng xuất tài khoản -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }

    if(isLoginA()) {
        $token = getSession('logintokena');
        delete('logintokena', "token='$token'");
        removeSession('logintokena');
        redirect(_WEB_HOST.'/admin/login');
    } else {
        redirect(_WEB_HOST.'/admin/login');
    }