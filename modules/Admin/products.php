<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
  die('Access denied...');
}

if (!isLoginA() || (role() != 'Admin' && role() != 'Staff')) {
  setFlashData('smg', 'You do not have permission to access this page and have been logged out!');
  setFlashData('smg_type', 'danger');
  getSmg($smg, $smg_type);
  redirect('/BnL/admin/logout');
}

?>
<!doctype html>
<html lang="en">

<head>
  <title>BnL - Products</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="BnL">

  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/css/dashboard.css">
  
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

</head>

<body>

  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar" class="active">
      <h1><a href="/BnL/public/home" target="_blank" class="logo">BnL</a></h1>
      <ul class="list-unstyled components mb-5">
        <li class="">
          <a href="dashboard"><span class="tf-ion-ios-home"></span> Home</a>
        </li>
        <li class="">
          <a href="hrm"><span class="tf-ion-android-people"></span> HRM</a>
        </li>
        <li class="active">
          <a href="products"><span class="tf-basket"></span> Products</a>
        </li>
        <li class="">
          <a href="customers"><span class="tf-ion-android-contacts"></span> Customers</a>
        </li>
        <li class="">
          <a href="orders"><span class="tf-ion-tshirt"></span> Orders</a>
        </li>
      </ul>
    </nav>

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5">
     <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            
                <button type="button" id="sidebarCollapse" class="btn btn-success">
                  <i class="tf-ion-navicon-round"></i>
                  <span class="sr-only">Toggle Menu</span>
                </button>

              <div class="ml-auto">
                <ul class="nav navbar-nav">
                  <li class="dropdown dropdown-slide">
                  <?php 
                      $adminQuery = oneRow("SELECT administrator.email, administrator.role
                      FROM administrator
                      INNER JOIN logintokena ON administrator.adminid = logintokena.adminid
                      WHERE logintokena.token = '" . getSession('logintokena') . "'");
                      $email =  $adminQuery['email'];
                      $role = $adminQuery['role'];
                      $parts = explode("@", $email);
                      $username = $parts[0];
                      echo $username. ' ('. $role . ')';	
                    ?>
                    <span class="tf-ion-ios-arrow-down"></span>
                    <ul class="dropdown-menu ml-0">
                      <li><a href="/BnL/admin/create">Create Account</a></li>
                      <li><a href="/BnL/admin/reset_login">Reset Password</a></li>
                      <li><a href="/BnL/admin/logout">Logout</a></li>
                    </ul>
                  </li>
                </ul>
              </div>

          </nav>
        </div>

<!-- Nội dung của dashboard -->
      <h2 class="mb-4">Sidebar #07</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
  </div>
</body>

</html>

<?php layouts('footer_dashboard'); ?>