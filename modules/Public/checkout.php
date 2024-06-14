<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}

// Kiểm tra đăng nhập
if (!isLogin()) {
    setFlashData('smg', 'You need to log in to your account first');
    setFlashData('smg_type', 'danger');
    redirect(_WEB_HOST.'/user/login');
    exit;
} 

// Lấy thông tin token đăng nhập
$tokenLogin = getSession('logintokenc');

// Kiểm tra giỏ hàng có sản phẩm không
$countCart = countRows("SELECT * FROM cart WHERE Token = '$tokenLogin'");
if ($countCart == 0) {
    setFlashData('smg', 'Your cart is empty. Please add products to proceed.');
    setFlashData('smg_type', 'danger');
    redirect(_WEB_HOST.'/public/cart'); // Chuyển hướng đến trang giỏ hàng
    exit;
}

$data = [
    'pageTitle' => 'BnL - Checkout'
];
layouts('header_login', $data);

// Lấy CustomerID từ bảng customer dựa vào Token của session logintokenc
$customerQuery = oneRow("SELECT CustomerID FROM customer WHERE CustomerID = (SELECT CustomerID FROM logintokenc WHERE Token = '$tokenLogin')");

if ($customerQuery) {
    $customerID = $customerQuery['CustomerID'];

    // Tính tổng số tiền của giỏ hàng (cart)
    $total = oneRow("SELECT ROUND(SUM(Quantity * Price - (Price * Quantity * Discount / 100)), 2) AS Total
                    FROM cart WHERE Token = '$tokenLogin'");

    // Thêm dữ liệu vào bảng orders
    $dataInsertO = [
        'CustomerID' => $customerID,
        'OrderDate' => date('Y-m-d H:i:s'),
        'Status' => 'Pending',
        'TotalAmount' => $total['Total']
    ];
    $insertStatusO = insert('orders', $dataInsertO);

    if ($insertStatusO) {
        // Lấy thông tin giỏ hàng (cart)
        $cart = getRows("SELECT * FROM cart WHERE Token = '$tokenLogin'");

        // Lấy thông tin đơn hàng mới nhất
        $latestOrder = oneRow("SELECT * FROM orders WHERE CustomerID = '$customerID' ORDER BY OrderDate DESC LIMIT 1");

        // Cập nhật StockQuantity của từng sản phẩm trong giỏ hàng
        foreach ($cart as $item) {
            $productID = $item['ProductID'];
            $quantityOrdered = $item['Quantity'];

            // Lấy thông tin sản phẩm hiện tại
            $currentProduct = oneRow("SELECT StockQuantity FROM products WHERE ProductID = '$productID'");
            if ($currentProduct) {
                $currentStockQuantity = $currentProduct['StockQuantity'];

                // Tính toán StockQuantity mới
                $newStockQuantity = max(0, $currentStockQuantity - $quantityOrdered); // Đảm bảo không âm

                // Cập nhật vào bảng products
                $dataUpdate = [
                    'StockQuantity' => $newStockQuantity,
                ];
                $condition = "ProductID = '$productID'";
                update('products', $dataUpdate, $condition);

                // Thêm dữ liệu vào bảng orderdetails
                $dataInsertOD = [
                    'OrderID' => $latestOrder['OrderID'],
                    'ProductID' => $productID,
                    'Quantity' => $quantityOrdered,
                    'Discount' => $item['Discount']
                ];
                insert('orderdetails', $dataInsertOD);
            }
        }

        // Xóa giỏ hàng sau khi đã đặt hàng thành công 
        delete('cart', "Token = '$tokenLogin'");

        // Hiển thị thông báo thành công cho người dùng
        ?>
        <section class="page-wrapper success-msg">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="block text-center">
                            <i class="tf-ion-android-checkmark-circle"></i>
                            <h2 class="text-center">Thank you! For your purchase</h2>
                            <p>Your order has been placed successfully.</p>
                            <a href="<?php echo _WEB_HOST?>/public/shop" class="btn btn-main mt-20">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /.page-wrapper -->
        <?php
    } else {
        // Nếu không thể thêm đơn hàng vào cơ sở dữ liệu
        setFlashData('smg', 'Failed to place order. Please try again later.');
        setFlashData('smg_type', 'danger');
        redirect(_WEB_HOST.'/public/cart');
    }
} else {
    // Nếu không tìm thấy CustomerID trong logintokenc
    setFlashData('smg', 'Customer information not found.');
    setFlashData('smg_type', 'danger');
    redirect(_WEB_HOST.'/user/logout');
}

layouts('footer');
?>
