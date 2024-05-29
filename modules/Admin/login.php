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
          $adminQuery = oneRow("SELECT adminID, password FROM administrator WHERE email = '$email'");

          if (!empty($adminQuery)) {
              $passwordHash = $adminQuery['password'];
              $adminId = $adminQuery['adminID'];
              if (password_verify($password, $passwordHash)) {
                // Tạo token login
                $tokenLogin = sha1(uniqid().time());

                // insert vào bảng loginTokenC
                $dataInsert = [
                  'adminID' => $adminId,
                  'token' => $tokenLogin,
                  'create_at' => date('y-m-d H:i:s')
                ];

                $insertStatus = insert('logintokena', $dataInsert);
                if($insertStatus) {
                  setSession('logintokena', $tokenLogin);
                  if(role() == 'Admin') {
                    redirect('/BnL/admin/dashboard');
                  } if(role() == 'Staff') {
                    redirect('/BnL/admin/products');
                  } if(role() == 'Shipper') {
                    redirect('/BnL/admin/orders');
                  } else {
                    redirect('/BnL/admin/logout');
                  }
                } else {
                  setFlashData('smg', 'Unable to login, please try again later!');
                  setFlashData('smg_type', 'danger');
                }
              } else {
                setFlashData('smg', 'Incorrect password!');
                setFlashData('smg_type', 'danger');
              }
          } else {
            setFlashData('smg', 'Email does not exist or you do not have permission to access!');
            setFlashData('smg_type', 'danger');
          }
      } else {
          setFlashData('smg', 'Please enter your email and password!');
          setFlashData('smg_type', 'danger');
      }
      redirect('/BnL/admin/login');
    }
  
  $smg = getFlashData('smg');
  $smg_type = getFlashData('smg_type');
?>

    <title>BnL - Login</title>

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
          </div>
        </div>
      </div>
    </div>
  </section>

</body>
