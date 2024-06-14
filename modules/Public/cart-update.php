<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isLogin()) {
    setFlashData('smg', 'You need to log in to your account first');
    setFlashData('smg_type', 'danger');
    redirect(_WEB_HOST.'/user/logout');
} else {
// Check if form is submitted and process update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_item'])) {
    $tokenLogin = getSession('logintokenc');

    // Loop through POST data to update each item
    foreach ($_POST['quantity'] as $productID => $newQuantity) {
        // Validate and sanitize $newQuantity if needed
        $newQuantity = (int)$newQuantity;
        if ($newQuantity > 0) {
            $dataUpdate = [
                'Quantity' => $newQuantity
            ];

            $condition = "ProductID = $productID AND Token = '$tokenLogin'";
            $updateStatus = update('cart', $dataUpdate, $condition);

            // Check update result
            if ($updateStatus) {
                // Update successful, set flash message if needed
                setFlashData('smg', 'Quantity updated successfully.');
                setFlashData('smg_type', 'success');
            } else {
                // Update failed, set error message
                setFlashData('smg', 'Failed to update quantity.');
                setFlashData('smg_type', 'error');
            }
        } else {
            setFlashData('smg', 'Invalid quantity value.');
            setFlashData('smg_type', 'error');
        }
    }

    redirect(_WEB_HOST.'/public/cart');
} else {
    // Redirect or handle unauthorized access
    redirect(_WEB_HOST.'/error/404');
    exit;
}
}
?>
