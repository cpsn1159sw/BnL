<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}

if (!isLogin()) {
    setFlashData('smg', 'You need to log in to your account first');
    setFlashData('smg_type', 'danger');
    redirect('/BnL/user/logout');
} else {
    $filterAll = filter();
    if (!empty($filterAll['id'])) {
        $productID = $filterAll['id'];
        $tokenLogin = getSession('logintokenc');

        $info = getRows("SELECT * FROM cart WHERE ProductID = $productID AND Token = '$tokenLogin'");

            $dataUpdate = [
                'Quantity' => $filterAll['quantity'],
            ];

            $condition = "ProductID = $productID";
            $insertStatus = update('cart', $dataUpdate, $condition);
            if ($insertStatus) {
                setFlashData('smg', 'Update successful!');
                setFlashData('smg_type', 'success');
            } else {
                setFlashData('smg', 'The system is experiencing issues. Please try again later!');
                setFlashData('smg_type', 'danger');
            }

        redirect('/BnL/public/cart');
    }
}

?>
