<?php

$filterAll = filter();
if (!empty($filterAll['ProductID'])) {
    $product_id = $filterAll['ProductID'];
    $info = getRows("SELECT * FROM products WHERE ProductID = $product_id");
    $_SESSION['cart'][] = [
        'ProductID' => $info['ProductID'],
        'Name' => $info['Name'],
        'Price' => $info['Price'],
        'Quantity' => 1 // Số lượng mặc định ban đầu
    ];
}

// Thêm sản phẩm vào giỏ hàng

redirect('cart');
?>