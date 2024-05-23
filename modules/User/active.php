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
                setFlashData('smg', 'Kích hoạt tài khoản thành công bạn đã có thể đăng nhập ngay bây giờ!');
                setFlashData('smg_type', 'success');
            } else {
                setFlashData('smg', 'Kích hoạt tài khoản không thành công, vui lòng liên CSKH BnL!');
                setFlashData('smg_type', 'danger');
            }
            
            redirect('/BnL/user/login');
        } else {
            getSmg('Liên kết không tồn tại hoặc đã hết hạn!', 'danger');
        }
    } else {
        getSmg('Liên kết không tồn tại hoặc đã hết hạn!', 'danger');
    }
?>
  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/themefisher-font/style.css">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/bootstrap/css/bootstrap.min.css">
  
  <!-- Animate css -->
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/animate/animate.css">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/slick/slick.css">
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/slick/slick-theme.css">
  
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/css/style.css">
