<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }

    if (isLoginA() && (role() == 'Admin' || role() == 'Staff')) {
    $filterAll = filter();
    if(!empty($filterAll['id'])) {
        $CustomerID = $filterAll['id'];
        $info = getRows("SELECT * FROM customer WHERE CustomerID = $CustomerID");
        if($info > 0) {
            $deleteToken = delete('logintokenc', "CustomerID = $CustomerID");
            if ($deleteToken) {
                $deleteA = delete('customer', "CustomerID = $CustomerID");
                if($deleteA) {
                    setFlashData('smg', 'Delete successful!');
                    setFlashData('smg_type', 'success');
                } else {
                    setFlashData('smg', 'The system is experiencing issues. Please try again later!');
                    setFlashData('smg_type', 'danger');
                }
            }
        } else {
            setFlashData('smg', 'This account does not exist!');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('smg', 'The link does not exist or has expired!');
        setFlashData('smg_type', 'danger');
    }
     redirect(_WEB_HOST.'/admin/customers');
} else {
    setFlashData('smg', 'You do not have permission to access this page and have been logged out!');
    setFlashData('smg_type', 'danger');
    getSmg($smg, $smg_type);
    redirect(_WEB_HOST.'/admin/logout');
}