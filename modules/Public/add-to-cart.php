<?php
// Chặn truy cập hợp lệ
// if (!defined('_CODE')) {
//     die('Access denied...');
// }
// Kiểm tra xem session đã bắt đầu chưa
if (session_status() == PHP_SESSION_NONE) {
    // Nếu session chưa được bắt đầu, bắt đầu một session mới
    session_start();
}
if (!isLogin()) {
    setFlashData('smg', 'You need to log in to your account first ');
    setFlashData('smg_type', 'danger');
    getSmg($smg, $smg_type);
    redirect('/BnL/user/login');
} else {
    if (isGet()) {
        $filterAll = filter();
        if (!empty($filterAll['id'])) {
            $productId = $filterAll['id'];
            $info = getRows("SELECT * FROM products WHERE ProductID = '$productId'");
            // Lấy giỏ hàng hiện tại từ session
            $cart = getSession('cart');


            // Nếu giỏ hàng chưa tồn tại, tạo một mảng mới
            if (empty($cart)) {
                $cart = array();
            }

            // Thêm sản phẩm mới vào giỏ hàng
            $cart[] = $info;
            // Lưu lại giỏ hàng vào session
            setSession('cart', $info);
        }
    }

    // print_r($productId);
    echo "Thông tin của session 'cart':<br>";
    var_dump(getSession('cart'));
    // redirect("cart");
}
