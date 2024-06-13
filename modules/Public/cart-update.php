<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

// Include necessary functions and database connection

// Check if form is submitted and process update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_item'])) {
    $tokenLogin = getSession('logintokenc');

    // Loop through POST data to update each item
    foreach ($_POST['quantity'] as $productID => $newQuantity) {
        $dataUpdate = [
            'Quantity' =>$newQuantity
        ];

        $condition = "ProductID = $productID AND Token = '$tokenLogin'";
        $insertStatus = update('cart', $dataUpdate, $condition);
        
        // Check update result
        if ($insertStatus) {
            // Update successful, set flash message if needed
            setFlashData('smg', 'Quantity updated successfully.');
            setFlashData('smg_type', 'success');
        } else {
            // Update failed, set error message
            setFlashData('smg', 'Failed to update quantity.');
            setFlashData('smg_type', 'error');
        }
    }

    // Redirect back to cart page to show updated quantities
    header('Location: cart');
    exit;
} else {
    // Redirect or handle unauthorized access
    header('Location: error'); // Redirect to an error page
    exit;
}
?>
