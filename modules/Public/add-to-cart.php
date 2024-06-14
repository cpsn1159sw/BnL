<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

// Kiểm tra người dùng đã đăng nhập chưa
if (!isLogin()) {
    setFlashData('smg', 'You need to log in to your account first');
    setFlashData('smg_type', 'danger');
    redirect('/BnL/user/login');
} else {
    if (isGet()) {
        $filterAll = filter();
        if (!empty($filterAll['id'])) {
            $productId = $filterAll['id'];

            // Lấy thông tin sản phẩm từ cơ sở dữ liệu
            $info = getRows("SELECT * FROM products WHERE ProductID = '$productId'");

            if (!empty($info)) {
                $tokenLogin = getSession('logintokenc');
                $queryToken = oneRow("SELECT Token FROM logintokenc WHERE token = '$tokenLogin'");
                $cart = getRows("SELECT * FROM cart WHERE token = '$tokenLogin' AND ProductID = '$productId'");
                if($cart>1) {
                    setFlashData('smg', 'This product has already been added');
                    setFlashData('smg_type', 'info');
                } else {
                    foreach ($info as $item) {
                        // Chuẩn bị dữ liệu để insert vào bảng cart
                        $dataInsert = [
                            'Name' => $item['Name'],
                            'Price' => $item['Price'],
                            'Image' => $item['imageURL'],
                            'Quantity' => 1, // Số lượng mặc định khi thêm vào giỏ hàng
                            'Discount' => $item['Discount'],
                            'Token' => $queryToken['Token'],
                            'ProductID' => $item['ProductID'],
                        ];
    
                        // Thêm vào bảng cart
                        $insertStatus = insert('cart', $dataInsert);
                        
                        if ($insertStatus) {
                            setFlashData('smg', 'Product added to cart successfully');
                            setFlashData('smg_type', 'success');
                        } else {
                            setFlashData('smg', 'Add product to cart failed');
                            setFlashData('smg_type', 'danger');
                        }
                    }
                }

            } else {
                setFlashData('smg', 'Product not found');
                setFlashData('smg_type', 'danger');
            }
        } else {
            setFlashData('smg', 'Invalid product ID');
            setFlashData('smg_type', 'danger');
        }
    }
}
?>
<script>
        window.onload = function() {
            // Thêm một chút thời gian để người dùng có thể thấy trang trước khi nó đóng
            setTimeout(function() {
                window.close();
            }, -100000); 
        }
    </script>