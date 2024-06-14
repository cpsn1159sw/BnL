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
        $errors['fullname']['required'] = '*Please enter your full name.';
    } else {
        if (strlen($filterAll['fullname']) < 5) {
            $errors['fullname']['min'] = '*Full name must be at least 5 characters.';
        }
    }

    // Validate email
    if (empty($filterAll['email'])) {
        $errors['email']['required'] = '*Please enter your email.';
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT customerid FROM customer WHERE email = '$email'";
        if (countRows($sql) > 0) {
            $errors['email']['unique'] = '*Email already exists.';
        }
    }

    // Validate phonenumber
    if (empty($filterAll['phone'])) {
        $errors['phone']['required'] = '*Please enter your phone number.';
    } else {
        if (!isPhone($filterAll['phone'])) {
            $errors['phone']['isPhone'] = '*The phone number is invalid.';
        } else {
          $phone = $filterAll['phone'];
          $query = "SELECT customerid FROM customer WHERE phone = '$phone'";
          if (countRows($query) > 0) {
            $errors['phone']['unique'] = '*Phone already exists.';
        }
        }
    }

    // Validate password
    if (empty($filterAll['password'])) {
        $errors['password']['required'] = '*Please enter your password.';
    } else {
        if (strlen($filterAll['password']) < 8) {
            $errors['password']['min'] = '*The password must be at least 8 characters.';
        }
    }

    // Validate password confirm
    if (empty($filterAll['cf-password'])) {
        $errors['cf-password']['required'] = '*You must re-enter your password.';
    } else {
        if ($filterAll['cf-password'] !== $filterAll['password']) {
            $errors['cf-password']['match'] = '*The re-entered password is incorrect.';
        }
    }

    // Validate address
    if (empty($filterAll['address'])) {
      $errors['address']['required'] = '*Please enter your address.';
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
        $subject = 'Activate your BnL account';
        $content = 'Hello '.$filterAll['fullname']. ',' .'<br>' .'
        
        Thank you for registering an account with BnL.' .'<br>' .'
                
        To complete the registration process and activate your account, please click the link below:' .'<br>'
                
        .$linkActive .'<br>' .'
                
        If you did not sign up for a BnL account, please disregard this email.' .'<br>' .'
                
        Thank you,' .'<br>' .'
        BnL Customer Support Team!';

        // Gữi mail
        $senMail = sendMail($filterAll['email'], $subject, $content);
        if($senMail) {
          setFlashData('smg', 'Sign up successful! Please check your email to activate your account!');
          setFlashData('smg_type', 'success');
        } else {
          setFlashData('smg', 'The system is experiencing issues. Please try again later!');
          setFlashData('smg_type', 'danger');
        }
      } else {
        setFlashData('smg', 'Sign up unsuccessful!');
        setFlashData('smg_type', 'danger');
      }
       redirect(_WEB_HOST.'/user/signup');
    } else {
        setFlashData('smg', 'Please check the information again!');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
        redirect(_WEB_HOST.'/user/signup');
    }
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>

    <title>BnL - Sign up</title>

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
            <a class="logo" href="<?php echo _WEB_HOST ?>/public/home">
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
                <input name="address" type="text" class="form-control"  placeholder="Address" value="<?php echo old_data('address', $old) ?>">
              </div>
              <?php 
                  // echo (!empty($errors['fullname'])) ? '<span class="er">'.reset($errors['fullname']).'</span>' : null;
                  echo form_error('address', '<span class="er">', '</span>', $errors);
                ?>
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
                <button type="submit" class="btn btn-main text-center">Sign Up</button>
              </div>
            </form>
            <p class="mt-20">Already have an account ?<a href="<?php echo _WEB_HOST ?>/user/login"> Login</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
</body>
