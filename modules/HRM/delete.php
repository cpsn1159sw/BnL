<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }

    if (isLoginA() && role() == 'Admin') {
    $filterAll = filter();
    if(!empty($filterAll['id'])) {
        $adminID = $filterAll['id'];
        $info = getRows("SELECT * FROM administrator WHERE adminID = $adminID");
        if($info > 0) {
            $deleteToken = delete('logintokena', "adminID = $adminID");
            if ($deleteToken) {
                $deleteA = delete('administrator', "adminID = $adminID");
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
     redirect('/BnL/admin/hrm');
} else {
    setFlashData('smg', 'You do not have permission to access this page and have been logged out!');
    setFlashData('smg_type', 'danger');
    getSmg($smg, $smg_type);
    redirect('/BnL/admin/logout');
}