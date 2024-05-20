
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }
?>

    <title>BnL - Đăng nhập</title>

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
          <div class="block text-center margin-0">
            <a class="logo" href="../public/home">
              <img src="<?php echo _WEB_HOST_TEMPLATES ?>/images/logo/BnL_logo.png" alt="" style="height: 20vh;">
            </a>
            <h2 class="text-center">Welcome Back</h2>
            <form class="text-left clearfix" action="" method="post">
              <div class="form-group">
                <input type="email" class="form-control"  placeholder="Email">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Password">
              </div>
              <div class="form-group">
                <p><a href="forgot">forgot password</a></p>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-main text-center" >Login</button>
              </div>
            </form>
            <p class="mt-20">New in this site ?<a href="signup"> Create New Account</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>
