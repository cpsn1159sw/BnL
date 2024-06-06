<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
  die('Access denied...');
}

if (isLoginA() && (role() == 'Admin' || role() == 'Staff' || role() != 'Shipper')) {

} else {
  setFlashData('smg', 'You do not have permission to access this page and have been logged out!');
  setFlashData('smg_type', 'danger');
  getSmg($smg, $smg_type);
  redirect('/BnL/admin/logout');
}

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');

$search = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $search = $_POST['search'];
}

?>
<!doctype html>
<html lang="en">

<head>
  <title>BnL - Orders</title>
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
        <li class="">
          <a href="products"><span class="tf-basket"></span> Products</a>
        </li>
        <li class="">
          <a href="customers"><span class="tf-ion-android-contacts"></span> Customers</a>
        </li>
        <li class="">
          <a href="exchange"><span class="tf-ion-reply"></span> Exchange</a>
        </li>
        <li class="active">
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
      <h2 class="mb-4">Orders</h2>
      <?php
      if (!empty($smg)) {
        getSmg($smg, $smg_type);
      }
      ?>
     
      <form action="" method="post" class="mt-3 mb-lg-2">
        <input type="search" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control" placeholder="Search...">
      </form>
      <table class="table table-bordered" id="">
        <thead>
          <th width="2%">ID</th>
          <th>Full Name</th>
          <th>Address</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Order ID</th>
          <th>Order Date</th>
          <th width="2%">Total</th>
          <th>Status</th>
        </thead>
        <?php 
        // Truy vấn dữ liệu
        if (!empty($search)) {
          $query = "SELECT o.CustomerID, 
            c.FullName, 
            c.Address, 
            c.Email, 
            c.Phone, 
            o.OrderID, 
            o.OrderDate AS OrderDate, 
            o.TotalAmount AS Total, 
            o.Status AS Status 
            FROM orders o
            LEFT JOIN customer c ON c.CustomerID = o.CustomerID
            WHERE c.FullName LIKE '%$search%' OR c.Email LIKE '%$search%' OR c.Phone LIKE '%$search%'
            GROUP BY o.CustomerID, c.FullName, c.Address, c.Email, c.Phone, o.OrderID, DATE(o.OrderDate), o.TotalAmount, o.Status";
        } else {
          $query = "SELECT o.CustomerID, 
            c.FullName, 
            c.Address, 
            c.Email, 
            c.Phone, 
            o.OrderID, 
            o.OrderDate AS OrderDate, 
            o.TotalAmount AS Total, 
            o.Status AS Status 
            FROM orders o
            LEFT JOIN customer c ON c.CustomerID = o.CustomerID
            GROUP BY o.CustomerID, c.FullName, c.Address, c.Email, c.Phone, o.OrderID, DATE(o.OrderDate), o.TotalAmount, o.Status";
        }

        $list = getRows($query);
        ?>
        <tbody>
          <?php
          if (!empty($list)) :
            $count = 0;
            foreach ($list as $item) :
              $count++;
          ?>
              <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $item['FullName']; ?></td>
                <td><?php echo $item['Address']; ?></td>
                <td><?php echo $item['Email']; ?></td>
                <td><?php echo $item['Phone']; ?></td>
                <td><?php echo $item['OrderID']; ?></td>
                <td><?php echo $item['OrderDate']; ?></td>
                <td><?php echo $item['Total']; ?></td>
                <td>
                  <form method="POST" action="/BnL/admin/orders_status">
                    <input type="hidden" name="orderId" value="<?php echo $item['OrderID']; ?>">
                    <input type="hidden" name="custo" value="<?php echo $item['OrderID']; ?>">
                    <div class="form-group">
                      <select name="status" class="form-control" onchange="this.form.submit()">
                        <?php 
                        $statusOptions = ['Delivered', 'Pending', 'Cancelled']; // Các tùy chọn trạng thái
                        foreach ($statusOptions as $option) {
                          $selected = $item['Status'] == $option ? 'selected' : '';
                          echo "<option value='$option' $selected>$option</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </form>
                </td>
              </tr>
            <?php
            endforeach;
          else :
            ?>
            <tr>
              <td colspan="9">
                <div class="alert alert-danger text-center">Empty</div>
              </td>
            </tr>
          <?php
          endif;
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>

<?php layouts('footer_dashboard'); ?>
