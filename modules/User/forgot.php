<!-- Quên mật khẩu tài khoản -->
<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}

if (isPost()) {
    $filterAll = filter();
    if (!empty($filterAll['email'])) {
        $email = $filterAll['email'];
        $emailQuery = oneRow("SELECT id FROM customer WHERE email = '$email' AND status = 1");
        if (!empty($emailQuery)) {
            $customerId = $emailQuery['id'];

            //Tạo forgot token 
            $forgotToken = sha1(uniqid() . time());

            $dataUpdate = [
                'forgotToken' => $forgotToken
            ];

            $updateStatus = update('customer', $dataUpdate, "id=$customerId");
            if ($updateStatus) {
                // Tạo link reset, khôi phục mật khẩu 
                $linkReset = _WEB_HOST . '?module=user&action=reset&token=' . $forgotToken;

                // Soạn tin gữi mail
                $subject = 'Password Reset for BnL Account';
                $content = 'Hello,' . '<br>' . ' 

                We have received a request to reset the password for your BnL account. 

                To ensure security, please follow these steps to reset your password:' . '<br>' . '  

                1. Click the link below or copy and paste it into your browser:' . '<br>'
                . $linkReset . '<br>' . '

                2. After accessing the link, you will be prompted to enter a new password. 
                Please ensure your new password is strong and memorable. 
                We recommend using at least 8 characters including uppercase letters, lowercase letters, numbers, and special characters.' . '<br>' . '

                3. Confirm your new password by re-entering it in the confirmation box.' . '<br>' . '      

                If you did not request a password reset, please disregard this email and ensure your account remains secure.' . '<br>' . '
                If you encounter any issues during the password reset process, 
                please contact our customer support team via email at cskhbandl@gmai.com or phone number [0123-456-789].' . '<br>' . '         
                Thank you for using BnL services!' . '<br>' . '
                Best regards,' . '<br>' . '
                BnL Customer Support Team';

                $sendEmail = sendMail($email, $subject, $content);

                if ($sendEmail) {
                    setFlashData('smg', 'Please check your email for instructions on resetting your password!');
                    setFlashData('smg_type', 'success');
                } else {
                    setFlashData('smg', 'System error. Please try again later!');
                    setFlashData('smg_type', 'danger');
                }
            }
        } else {
            setFlashData('smg', 'Email address does not exist in the system or the account has not been activated!');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('smg', 'Please enter an email address!');
        setFlashData('smg_type', 'danger');
    }
}

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>

<title>BnL - Forgot password</title>
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
                        <?php
                        if (!empty($smg)) {
                            getSmg($smg, $smg_type);
                        }
                        ?>
                        <form class="text-left clearfix" action="" method="post">
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