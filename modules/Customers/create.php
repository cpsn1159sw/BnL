<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
  die('Access denied...');
}

// Kiểm tra vai trò đăng nhập
if (isLoginA() && (role() == 'Admin' || role() == 'Staff')) {

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
          $errors['phone']['unique'] = '*This phone already exists.';
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

    // Validate role
    if (empty($filterAll['Status'])) {
      $errors['Status']['required'] = '*Please choose your status.';
    }

    // Validate address
    if (empty($filterAll['address'])) {
      $errors['address']['required'] = '*Please enter your address.';
    }

    if (empty($errors)) {
      $activeToken = sha1(uniqid() . time());
      $dataInsert = [
        'fullname' => $filterAll['fullname'],
        'address' => $filterAll['address'],
        'email' => $filterAll['email'],
        'phone' => $filterAll['phone'],
        'password' => password_hash(($filterAll['password']), PASSWORD_DEFAULT),
        'Status' => $filterAll['Status'],
        'create_at' => date('Y-m-d H:i:s')
      ];

      $insertStatus = insert('customer', $dataInsert); // NHỚ ĐỔI LẠI TÊN BẲNG customer SAU NÀY 
      if ($insertStatus) {
        setFlashData('smg', 'Create unsuccessful!');
        setFlashData('smg_type', 'success');
        redirect(_WEB_HOST.'/admin/customers');
      } else {
        setFlashData('smg', 'The system is experiencing issues. Please try again later!');
        setFlashData('smg_type', 'danger');
        redirect(_WEB_HOST.'/customers/create');
      }
    } else {
      setFlashData('smg', 'Please check the information again!');
      setFlashData('smg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $filterAll);
      redirect(_WEB_HOST.'/customers/create');
    }
  }
} else {
  setFlashData('smg', 'You do not have permission to access this page and have been logged out!');
  setFlashData('smg_type', 'danger');
  getSmg($smg, $smg_type);
  redirect(_WEB_HOST.'/admin/logout');
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>

<title>BnL - Create</title>

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
            <h2 class="text-center">
              <div class="text-left">
                <a href="<?php echo _WEB_HOST?>/admin/customers" class="btn btn-success"><i class=" tf-ion-arrow-left-c">Back</i></a>
              </div>Create User Account
            </h2>
            <?php
            if (!empty($smg)) {
              getSmg($smg, $smg_type);
            }
            ?>
            <form class="text-left clearfix" action="" method="post">
              <div class="form-group">
                <input name="fullname" type="text" class="form-control" placeholder="Full Name" value="<?php echo old_data('fullname', $old) ?>">
                <?php
                // echo (!empty($errors['fullname'])) ? '<span class="er">'.reset($errors['fullname']).'</span>' : null;
                echo form_error('fullname', '<span class="er">', '</span>', $errors);
                ?>
              </div>
              <div class="form-group">
                <input name="address" type="text" class="form-control" placeholder="Address" value="<?php echo old_data('address', $old) ?>">
              </div>
              <?php
              echo form_error('address', '<span class="er">', '</span>', $errors);
              ?>
              <div class="form-group">
                <input name="email" type="email" class="form-control" placeholder="Email" value="<?php echo old_data('email', $old) ?>">
                <?php
                echo form_error('email', '<span class="er">', '</span>', $errors);
                ?>
              </div>
              <div class="form-group">
                <input name="phone" type="text" class="form-control" placeholder="Phone Number" value="<?php echo old_data('phone', $old) ?>">
                <?php
                echo form_error('phone', '<span class="er">', '</span>', $errors);
                ?>
              </div>
              <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Password">
                <?php
                echo form_error('password', '<span class="er">', '</span>', $errors);
                ?>
              </div>
              <div class="form-group">
                <select name="Status" id="" class="form-control">
                  <option value="" disabled selected>Status</option>
                  <option value="1" <?php echo (old_data('Status', $old) == "1") ? 'selected' : false; ?>>Active</option>
                  <option value="NULL" <?php echo (old_data('Status', $old) == "NULL") ? 'selected' : false; ?>>None Active</option>
                </select>
                <?php
                echo form_error('Status', '<span class="er">', '</span>', $errors);
                ?>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-main text-center">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>