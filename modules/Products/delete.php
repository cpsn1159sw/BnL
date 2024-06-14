<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}

if (isLoginA() && (role() == 'Admin' || role() == 'Staff')) {
    $filterAll = filter();
    if (!empty($filterAll['id'])) {
        $ProductID = intval($filterAll['id']); // Sử dụng intval để đảm bảo rằng ProductID là một số nguyên
        $info = oneRow("SELECT StockQuantity FROM products WHERE ProductID = $ProductID");

        if (!empty($info)) {
            // Kiểm tra nếu sản phẩm có tồn tại
            // Và kiểm tra nếu có quyền xóa sản phẩm
            if ($info['StockQuantity'] == 0) {
                // Xóa sản phẩm
                $deleteP = delete('products', "ProductID = '$ProductID'");
                if ($deleteP) {
                    setFlashData('smg', 'Delete product successful!');
                    setFlashData('smg_type', 'success');
                } else {
                    setFlashData('smg', 'Failed to delete product. Please try again.');
                    setFlashData('smg_type', 'danger');
                }
            } else {
                setFlashData('smg', 'Can only delete when the product inventory is no longer available!');
                setFlashData('smg_type', 'danger');
            }
        } else {
            setFlashData('smg', 'This product does not exist!');
            setFlashData('smg_type', 'danger');
        }
        redirect('/BnL/admin/products');
    } else {
        setFlashData('smg', 'Product ID is missing!');
        setFlashData('smg_type', 'danger');
        redirect('/BnL/admin/products');
    }
} else {
    setFlashData('smg', 'You do not have permission to access this page and have been logged out!');
    setFlashData('smg_type', 'danger');
    getSmg($smg, $smg_type);
    redirect('/BnL/admin/logout');
}
?>
