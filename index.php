<?php
session_start();

require_once('config.php');

// Bao gồm các thư viện và tệp cần thiết
require_once('includes/phpmailer/Exception.php');
require_once('includes/phpmailer/PHPMailer.php');
require_once('includes/phpmailer/SMTP.php');

require_once('includes/connect.php');
require_once('includes/functions.php');
require_once('includes/database.php');
require_once('includes/session.php');

// Sử dụng các giá trị mặc định cho $module và $action
$module = isset($_GET['module']) ? trim($_GET['module']) : _MODULE;
$action = isset($_GET['action']) ? trim($_GET['action']) : _ACTION;

// Xác định đường dẫn của module và action
$path = 'modules/' . $module . '/' . $action . '.php';

// Kiểm tra xem tệp tồn tại hay không và bao gồm nó
if(file_exists($path)) {
    require_once($path);
} else {
    require_once('modules/error/404.php');
}
?>
