<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }

    if (isPost()) {
      $filterAll = filter();
      
      if (!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {
          // Kiểm tra đăng nhập
          $email = $filterAll['email'];
          $password = $filterAll['password'];

          // Truy vấn lấy thông tin đăng nhập theo email trong bảng customer 
          $customerQuery = oneRow("SELECT password FROM customer WHERE email = '$email'");

          if (!empty($customerQuery)) {
              $passwordHash = $customerQuery['password'];
              if (password_verify($password, $passwordHash)) {
                  echo 'Mật khẩu đúng.';
                  // Thực hiện hành động khi mật khẩu đúng
              } else {
                setFlashData('smg', 'Mật khẩu không chính xác!');
                setFlashData('smg_type', 'danger');
              }
          } else {
            setFlashData('smg', 'Email không tồn tại!');
            setFlashData('smg_type', 'danger');
          }
      } else {
          setFlashData('smg', 'Vui lòng nhập email và mật khẩu!');
          setFlashData('smg_type', 'danger');
      }
      redirect('login');
    }
  
  $smg = getFlashData('smg');
  $smg_type = getFlashData('smg_type');
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
            <a class="logo" href="/BnL/public/home">
              <img src="<?php echo _WEB_HOST_TEMPLATES ?>/images/logo/BnL_logo.png" alt="" style="height: 20vh;">
            </a>
            <h2 class="text-center">Welcome Back</h2>
            <?php 
              if(!empty($smg)) {
                getSmg($smg, $smg_type);
              }
            ?>
            <form class="text-left clearfix" action="" method="post">
              <div class="form-group">
                <input name="email" type="email" class="form-control"  placeholder="Email">
              </div>
              <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Password">
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
