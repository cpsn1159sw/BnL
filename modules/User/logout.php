<!-- Đăng xuất tài khoản -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }

    if(isLogin()) {
        $token = getSession('logintokenc');
        delete('logintokenc', "token='$token'");
        removeSession('logintokenc');
        redirect('/BnL/user/login');
    }