    <!-- Reset password -->
    <title>BnL - Reset password</title>

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

    <?php
    // Chặn truy cập hợp lệ
    if (!defined('_CODE')) {
      die('Access denied...');
    }

    $token = filter()['token'];
    if (!empty($token)) {
      // Truy vấn kiểm tra token
      $tokenQuery = oneRow("SELECT adminid FROM administrator WHERE forgotToken = '$token'");
      if (!empty($tokenQuery)) {
        $adminId = $tokenQuery['adminid'];
        if (isPost()) {
          $filterAll = filter();
          $error = [];

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

          if (empty($errors)) {
            // Xử lí update mật khẩu
            $passwordHash = password_hash($filterAll['password'], PASSWORD_DEFAULT);
            $dataUpdate = [
              'password' => $passwordHash,
              'forgotToken' => null,
              'update_at' => date('y-m-d H:i:s')
            ];

            $updateStatus = update('administrator', $dataUpdate, "adminid = '$adminId'");
            if ($updateStatus) {
              setFlashData('smg', 'Password changed successfully!');
              setFlashData('smg_type', 'success');
              redirect(_WEB_HOST.'/admin/login');
            } else {
              setFlashData('smg', 'System error, please try again later!');
              setFlashData('smg_type', 'danger');
            }
          } else {
            setFlashData('smg', 'Please check your information again!');
            setFlashData('smg_type', 'danger');
            setFlashData('errors', $errors);
            redirect(_WEB_HOST.'?module=user&action=reset&token=' . $token);
          }
        }

        $smg = getFlashData('smg');
        $smg_type = getFlashData('smg_type');
        $errors = getFlashData('errors');
    ?>

        <!-- Form reset mật khẩu -->

        <body id="body">
          <section class="signin-page account">
            <div class="container">
              <div class="row">
                <div class="col-md-6 col-md-offset-3">
                  <div class="block text-center margin-0">
                    <h2 class="text-center">Reset Your Password</h2>
                    <?php
                    if (!empty($smg)) {
                      getSmg($smg, $smg_type);
                    }
                    ?>
                    <form class="text-left clearfix" action="" method="post">
                      <div class="form-group">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        <?php
                        echo form_error('password', '<span class="er">', '</span>', $errors);
                        ?>
                      </div>
                      <div class="form-group">
                        <input name="cf-password" type="password" class="form-control" placeholder="Confirm password">
                        <?php
                        echo form_error('cf-password', '<span class="er">', '</span>', $errors);
                        ?>
                      </div>
                      <input type="hidden" name="token" value="<?php echo $token; ?>">
                      <div class="text-center">
                        <button type="submit" class="btn btn-main text-center">Confirm</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </body>
    <?php
      } else {
        getSmg('The link does not exist or has expired!', 'danger');
      }
    } else {
      getSmg('The link does not exist or has expired!', 'danger');
    }

    ?>