<?php
// Chặn truy cập không hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}

// Kiểm tra quyền truy cập
if (isLoginA() && (role() == 'Admin' || role() == 'Staff' || role() == 'Shipper')) {
    
    $filterAll = filter();
    if (!empty($filterAll['orderId'])) {
        $orderId = $filterAll['orderId'];
    }

    if (isPost()) {
        $filterAll = filter();

        // Lấy dữ liệu status từ dữ liệu gửi đi bởi form
        $newStatus = $filterAll['status'];
        $orderId = $filterAll['orderId'];

        // Kiểm tra xem orderId và newStatus có tồn tại và hợp lệ không
        if ($newStatus && $orderId) {
            // Kiểm tra xem CustomerID có giá trị null hay không
            $customerID = oneRow("SELECT CustomerID FROM orders WHERE OrderID = $orderId")['CustomerID'];
            if ($customerID !== null) {
                $dataUpdate = [
                    'Status' => $newStatus
                ];
                $condition = "OrderID = $orderId";
                $updateStatus = update('orders', $dataUpdate, $condition);

                if ($updateStatus) {
                    // Thiết lập thông báo thành công dựa trên newStatus
                    $message = '';
                    switch ($newStatus) {
                        case 'Delivered':
                            $message = 'Delivered';
                            $type = 'success';
                            break;
                        case 'Pending':
                            $message = 'Pending';
                            $type = 'warning';
                            break;
                        case 'Cancelled':
                            $message = 'Cancelled';
                            $type = 'danger';
                            break;
                    }

                    setFlashData('smg', $message);
                    setFlashData('smg_type', $type);
                } else {
                    setFlashData('smg', 'Failed to update. Please try again later!');
                    setFlashData('smg_type', 'danger');
                }
            } else {
                setFlashData('smg', 'Cannot update this status!');
                setFlashData('smg_type', 'danger');
            }
        } else {
            setFlashData('smg', 'Invalid data received. Please try again later!');
            setFlashData('smg_type', 'danger');
        }
        redirect('/BnL/admin/orders');
    }

} else {
    // Nếu người dùng không có quyền truy cập, chuyển hướng và hiển thị thông báo
    setFlashData('smg', 'You do not have permission to access this page and have been logged out!');
    setFlashData('smg_type', 'danger');
    redirect('/BnL/admin/logout');
}
?>
