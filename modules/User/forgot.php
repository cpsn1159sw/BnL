<!-- Quên mật khẩu tài khoản -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }

    if (isPost()) {
        $filterAll = filter();
        if(!empty($filterAll['email'])) {
            $email = $filterAll['email'];
            $emailQuery = oneRow("SELECT id FROM customer WHERE email = '$email'");
            if(!empty($emailQuery)) {
                $customerId = $emailQuery['id'];

                //Tạo forgot token 
                $forgotToken = sha1(uniqid().time());

                $dataUpdate = [
                    'forgotToken' => $forgotToken
                ];

                $updateStatus = update('customer', $dataUpdate, "id=$customerId");
                if($updateStatus) {
                    // Tạo link reset, khôi phục mật khẩu 
                    $linkReset = _WEB_HOST. '?module=user&action=reset&token='. $forgotToken;
                    
                    // Soạn tin gữi mail
                    $subject = 'Khôi phục mật khẩu tài khoản BnL';
                    $content = 'Chào bạn,'.'<br>' .' 

                    Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản BnL của bạn. 
                    Để đảm bảo tính bảo mật, vui lòng thực hiện các bước sau để đặt lại mật khẩu của bạn:' .'<br>' .'
                    
                    1. Nhấp vào liên kết dưới đây hoặc sao chép và dán nó vào trình duyệt của bạn:' .'<br>'
                    
                    .$linkReset .'<br>' .'

                    2. Sau khi truy cập liên kết, bạn sẽ được yêu cầu nhập mật khẩu mới. Hãy đảm bảo mật khẩu mới của bạn đủ mạnh và dễ nhớ. 
                    Chúng tôi khuyến nghị sử dụng ít nhất 8 ký tự bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.' .'<br>' .'

                    3. Xác nhận mật khẩu mới của bạn bằng cách nhập lại mật khẩu vào ô xác nhận.' .'<br>' .'
                    
                    Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này và bảo đảm rằng tài khoản của bạn vẫn an toàn.' .'<br>' .'

                    Nếu bạn gặp bất kỳ vấn đề nào trong quá trình đặt lại mật khẩu, 
                    vui lòng liên hệ với đội ngũ hỗ trợ khách hàng của chúng tôi qua email cskhbandl@gmai.com hoặc số điện thoại [0123-456-789].' .'<br>' .'
                    
                    Cảm ơn bạn đã sử dụng dịch vụ của BnL!' .'<br>' .'
                    
                    Trân trọng,'.'<br>' .'
                    Đội ngũ hỗ trợ CSKH BnL';

                    $sendEmail = sendMail($email, $subject, $content);

                    if($sendEmail) {
                        setFlashData('smg', 'Vui lòng kiểm tra email để xem hướng dẫn đặt lại mật khẩu!');
                        setFlashData('smg_type', 'success');
                    } else {
                        setFlashData('smg', 'Lỗi hệ thống vui lòng thử lại sau!');
                        setFlashData('smg_type', 'danger');
                        
                    }
                }
            } else {
                setFlashData('smg', 'Địa chỉ email không tồn tại trong hệ thống!');
                setFlashData('smg_type', 'danger');
            }
        } else {
            setFlashData('smg', 'Vui lòng nhập địa chỉ Email!');
            setFlashData('smg_type', 'danger');
        }
      }
    
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>

    <title>BnL - Quên mật khẩu</title>
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

<body id="body">

    <section class="forget-password-page account">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                    <a class="logo" href="/BnL/public/home">
                        <img src="images/logo.png" alt="">
                    </a>
                    <h2 class="text-center">Reset Your Password Here</h2>
                    <form class="text-left clearfix">
                        <p>Please enter the email address for your account. A verification code will be sent to you. Once you have received the verification code, you will be able to choose a new password for your account.</p>
                        <div class="form-group">
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Account email address">
                        </div>
                        <div class="text-center">
                        <button type="submit" class="btn btn-main text-center">Request password reset</button>
                        </div>
                    </form>
                    <p class="mt-20"><a href="login">Back to log in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>