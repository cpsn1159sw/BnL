<!-- Kich hoạt tài khoản -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }

    $token = filter()['token'];
    if(!empty($token)) {
        // Truy vấn để kiểm tra token vs database
        $tokenQuery = oneRow("SELECT id FROM customer WHERE activeToken = '$token'");
        if(!empty($tokenQuery)) {
            $customerId = $tokenQuery['id'];
            $dataUpdate = [
                'status' => '1',
                'activeToken' => null
            ];
            $updateStatus = update('customer', $dataUpdate, "id = $customerId");

            if($updateStatus) {
                setFlashData('msg', 'Kích hoạt tài khoản thành công bạn đã có thể đăng nhập ngay bây giờ!');
                setFlashData('msg_type', 'success');
            } else {
                setFlashData('msg', 'Kích hoạt tài khoản không thành công, vui lòng liên CSKH BnL!');
                setFlashData('msg_type', 'danger');
            }
            
            redirect('/BnL/user/login');
        } else {
            getSmg('Liên kết không tồn tại hoặc đã hết hạn!', 'danger');
        }
    } else {
        getSmg('Liên kết không tồn tại hoặc đã hết hạn!', 'danger');
    }
?>
