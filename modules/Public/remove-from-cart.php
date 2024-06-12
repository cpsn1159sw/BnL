<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}
// Kiểm tra xem session đã bắt đầu chưa
if (session_status() == PHP_SESSION_NONE) {
    // Nếu session chưa được bắt đầu, bắt đầu một session mới
    session_start();
}

if (isGet()) {
    $filterAll = filter();
    if (!empty($filterAll['id'])) {
        $productId = $filterAll['id'];

        // Fetch the current cart session
        $cart = getSession('cart');

        // Check if the cart is not empty and contains the product
        if (!empty($cart)) {
            foreach ($cart as $item => $product) {
                if ($product['ProductID'] == $productId) {
                    // Remove the product from the cart
                    unset($cart[$item]);
                    break;
                }
            }
            // Update the cart session
            setSession('cart', $cart);
        }
    }
}
// print_r($productId);
echo "Thông tin của session 'cart':<br>";
var_dump(getSession('cart'));
redirect("cart");
?>