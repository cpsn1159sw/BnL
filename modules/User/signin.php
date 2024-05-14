<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }
$data = [
    'pageTitle' => 'BnL - Đăng ký'
];
?>

    <title>BnL - Đăng ký</title>

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

  <section class="signin-page account">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="block text-center">
            <a class="logo" href="index.html">
              <img src="images/logo.png" alt="">
            </a>
            <h2 class="text-center">Create Your Account</h2>
            <form class="text-left clearfix" action="index.html">
              <div class="form-group">
                <input type="text" class="form-control"  placeholder="Họ và tên">
              </div>
              <div class="form-group">
                <input type="text" class="form-control"  placeholder="Địa chỉ">
              </div>
              <div class="form-group">
                <input type="text" class="form-control"  placeholder="Username">
              </div>
              <div class="form-group">
                <input type="email" class="form-control"  placeholder="Email">
              </div>
              <div class="form-group">
                <input type="password" class="form-control"  placeholder="Password">
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-main text-center">Sign In</button>
              </div>
            </form>
            <p class="mt-20">Already hava an account ?<a href="?module=user&action=login"> Login</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
</body>
