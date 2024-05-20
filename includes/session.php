<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}

// Hàm gán session
function setSession($key, $value) {
    $_SESSION[$key] = $value;
}

// Hàm đọc session
function getSession($key = '') {
    if (!empty($key)) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    } else {
        return $_SESSION;
    }
}

// Hàm xóa session hoặc session key
function removeSession($key = '') {
    if (!empty($key)) {
        unset($_SESSION[$key]);
    } else {
        session_destroy();
    }
}

// Hàm gán flash data
function setFlashData($key, $value) {
    $key = 'flash_' . $key;
    setSession($key, $value);
    // Set a flag to indicate it's flash data
    setSession($key . '_is_flash', true);
}

// Hàm đọc flash data và xóa nó sau khi đọc
function getFlashData($key) {
    $key = 'flash_' . $key;
    $data = getSession($key);
    if (!empty($data) && getSession($key . '_is_flash')) {
        removeSession($key);
        removeSession($key . '_is_flash');
        return $data;
    } else {
        return null;
    }
}
?>
