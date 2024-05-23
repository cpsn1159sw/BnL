<!-- Reset password -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }

?>
<title>BnL - Khôi phục mật khẩu</title>

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
          <h2 class="text-center">Reset Your Password</h2>
          <?php 
            if(!empty($smg)) {
              getSmg($smg, $smg_type);
            }
          ?>
          <form class="text-left clearfix" action="" method="post">
            <div class="form-group">
              <input name="password" type="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
              <input name="cf-password" type="password" class="form-control" placeholder="Confirm Password">
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-main text-center" >Confirm</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

</body>