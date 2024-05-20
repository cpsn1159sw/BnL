<!-- Quên mật khẩu tài khoản -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }
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
                    <a class="logo" href="index.html">
                        <img src="images/logo.png" alt="">
                    </a>
                    <h2 class="text-center">Welcome Back</h2>
                    <form class="text-left clearfix">
                        <p>Please enter the email address for your account. A verification code will be sent to you. Once you have received the verification code, you will be able to choose a new password for your account.</p>
                        <div class="form-group">
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Account email address">
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