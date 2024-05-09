<!-- Quên mật khẩu tài khoản -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }
$data = [
    'pageTitle' => 'BnL - Quên mật khẩu'
];
layouts('header', $data);