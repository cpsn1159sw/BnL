<!-- Kết nối với Database -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }

    try {
        if(class_exists('PDO')) {
            $dsn = 'mysql:dbname='. _DB. ';host='. _HOST;
            $optiones = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //Set utf8
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //Tạo thông báo ra ngoại lệ khi gặp lỗi 
            ];
            $conn = new PDO($dsn, _USER, _PASS, $optiones);
        }
    } catch(Exception $exception) {
        echo '<div style="color:red; padding: 5px 15px; border: 1px solid red;">';
        echo $exception->getMessage(). '<br>';
        echo '</div>';
        die();
    }