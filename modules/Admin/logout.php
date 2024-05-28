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
        redirect('/BnL/admin/login');
    } else {
        redirect('/BnL/admin/login');
    }