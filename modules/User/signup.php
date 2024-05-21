<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}

if (isPost()) {
    $filterAll = filter();
    $errors = []; // Mảng chứa các lỗi

    // Validate fullname
    if (empty($filterAll['fullname'])) {
        $errors['fullname']['required'] = '*Họ và tên bắt buộc phải nhập.';
    } else {
        if (strlen($filterAll['fullname']) < 5) {
            $errors['fullname']['min'] = '*Họ và tên phải có ít nhất 5 kí tự.';
        }
    }

    // Validate email
    if (empty($filterAll['email'])) {
        $errors['email']['required'] = '*Email bắt buộc phải nhập.';
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT id FROM customer WHERE email = '$email'";
        if (countRows($sql) > 0) {
            $errors['email']['unique'] = '*Email đã tồn tại.';
        }
    }

    // Validate phonenumber
    if (empty($filterAll['phone'])) {
        $errors['phone']['required'] = '*Số điện thoại bắt buộc phải nhập.';
    } else {
        if (!isPhone($filterAll['phone'])) {
            $errors['phone']['isPhone'] = '*Số điện thoại không hợp lệ.';
        }
    }

    // Validate password
    if (empty($filterAll['password'])) {
        $errors['password']['required'] = '*Mật khẩu bắt buộc phải nhập.';
    } else {
        if (strlen($filterAll['password']) < 8) {
            $errors['password']['min'] = '*Mật khẩu phải có ít nhất 8 kí tự.';
        }
    }

    // Validate password confirm
    if (empty($filterAll['cf-password'])) {
        $errors['cf-password']['required'] = '*Bạn phải nhập lại mật khẩu.';
    } else {
        if ($filterAll['cf-password'] !== $filterAll['password']) {
            $errors['cf-password']['match'] = '*Mật khẩu nhập lại không đúng.';
        }
    }

    if (empty($errors)) {
      $activeToken = sha1(uniqid().time());
      $dataInsert = [
        'fullname' => $filterAll['fullname'],
        'address' => $filterAll['address'],
        'email' => $filterAll['email'],
        'phone' => $filterAll['phone'],
        'password' => password_hash(($filterAll['password']), PASSWORD_DEFAULT),
        'activeToken' => $activeToken,
        'create_at' => date('Y-m-d H:i:s')
      ];

      $insertStatus = insert('customer', $dataInsert); // NHỚ ĐỔI LẠI TÊN BẲNG customer SAU NÀY 
      if($insertStatus) {
        // Tạo link kích hoạt tài khoản
        $linkActive = _WEB_HOST . '?module=user&action=active&token='. $activeToken;

        // Soạn tin gữi mail
        $subject = 'Kích hoạt tài khoản BnLer';
        $content = 'Xin chào '.$filterAll['fullname']. ',' .'<br>' .'

        Cảm ơn bạn đã đăng ký tài khoản tại BnL.' .'<br>' .'
        
        Để hoàn tất quá trình đăng ký và kích hoạt tài khoản của bạn, vui lòng nhấp vào liên kết dưới đây:' .'<br>'
        
        .$linkActive .'<br>' .'
        
        Nếu bạn không đăng ký tài khoản tại BnL, vui lòng bỏ qua email này.' .'<br>' .'
        
        Cảm ơn bạn,' .'<br>' .'
        Đội ngũ hỗ trợ CSKH BnL';

        // Gữi mail
        $senMail = sendMail($filterAll['email'], $subject, $content);
        if($senMail) {
          setFlashData('smg', 'Đăng kí thành công, vui lòng kiểm tra email để kích hoạt tài khoản!!!');
          setFlashData('smg_type', 'success');
        } else {
          setFlashData('smg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
          setFlashData('smg_type', 'danger');
        }
      } else {
        setFlashData('smg', 'Đăng kí không thành công!');
        setFlashData('smg_type', 'danger');
      }
       redirect('/BnL/user/signup');
    } else {
        setFlashData('smg', 'Vui lòng kiểm tra lại thông tin!');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
        redirect('signup');
    }
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
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

  <section class="signup-page account">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="block text-center margin-0">
            <a class="logo" href="/BnL/public/home">
              <img src="<?php echo _WEB_HOST_TEMPLATES ?>/images/logo/BnL_logo.png" alt="" style="height: 20vh;">
            </a>
            <h2 class="text-center">Create Your Account</h2>
            <?php 
              if(!empty($smg)) {
                getSmg($smg, $smg_type);
              }
            ?>
            <form class="text-left clearfix" action="" method="post">
              <div class="form-group">
                <input name="fullname" type="text" class="form-control"  placeholder="Họ và tên" value="<?php echo old_data('fullname', $old) ?>">
                <?php 
                  // echo (!empty($errors['fullname'])) ? '<span class="er">'.reset($errors['fullname']).'</span>' : null;
                  echo form_error('fullname', '<span class="er">', '</span>', $errors);
                ?>
              </div>
              <div class="form-group">
                <input name="address" type="text" class="form-control"  placeholder="Address">
              </div>
              <div class="form-group">
                <input name="email" type="email" class="form-control"  placeholder="Email" value="<?php echo old_data('email', $old)?>">
                <?php 
                  echo form_error('email', '<span class="er">', '</span>', $errors);
                ?>
              </div>
              <div class="form-group">
                <input name="phone" type="text" class="form-control"  placeholder="Phone Number" value="<?php echo old_data('phone', $old) ?>">
                <?php 
                  echo form_error('phone', '<span class="er">', '</span>', $errors);
                ?>
              </div>
              <div class="form-group">
                <input name="password" type="password" class="form-control"  placeholder="Password">
                <?php 
                  echo form_error('password', '<span class="er">', '</span>', $errors);
                ?>
              </div>
              <div class="form-group">
                <input name="cf-password" type="password" class="form-control"  placeholder="Confirm password">
                <?php 
                  echo form_error('cf-password', '<span class="er">', '</span>', $errors);
                ?>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-main text-center">Sign In</button>
              </div>
            </form>
            <p class="mt-20">Already hava an account ?<a href="login"> Login</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
</body>
