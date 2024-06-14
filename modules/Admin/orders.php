<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
  die('Access denied...');
}

if (isLoginA() && (role() == 'Admin' || role() == 'Staff')) {
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
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/themefisher-font/style.css">
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/animate/animate.css">
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/slick/slick.css">
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/slick/slick-theme.css">
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/css/style.css">

  <style>
    .table-responsive {
      overflow-x: auto;
    }

    .form-control {
      width: 100%;
    }

    .table td,
    .table th {
      white-space: nowrap;
    }
  </style>
</head>

<body>

  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar" class="active">
      <h1><a href="/BnL/public/home" target="_blank" class="logo">BnL</a></h1>
      <ul class="list-unstyled components mb-5">
        <li class="">
          <a href="home"><span class="tf-ion-ios-home"></span> Home</a>
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
                echo $username . ' (' . $role . ')';
                ?>
                <span class="tf-ion-ios-arrow-down"></span>
                <ul class="dropdown-menu ml-0">
                  <li><a href="/BnL/admin/reset_login">Reset Password</a></li>
                  <li><a href="/BnL/admin/forgot">Forgot Password</a></li>
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
      <form action="" method="post" class="mt-3 mb-lg-3">
        <input type="search" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control" placeholder="Search...">
      </form>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <th width="2%">ID</th>
            <th>Full Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Order Date</th>
            <th>Status</th>
          </thead>
          <?php
          // Truy vấn dữ liệu
          if (!empty($search)) {
            $query = "SELECT
    c.FullName AS CustomerName,
    c.Address,
    c.Email,
    c.Phone,
    o.OrderDate,
    GROUP_CONCAT(p.Name) AS ProductsOrdered,
    SUM(od.Quantity * p.Price) AS TotalAmount,
    o.Status,
    o.OrderID,
    o.CustomerID
FROM 
    Orders o
LEFT JOIN 
    Customer c ON c.CustomerID = o.CustomerID
JOIN 
    OrderDetails od ON o.OrderID = od.OrderID
JOIN 
    Products p ON od.ProductID = p.ProductID
WHERE 
    c.FullName LIKE '%$search%' OR 
    c.Email LIKE '%$search%' OR 
    c.Phone LIKE '%$search%' OR 
    DATE(o.OrderDate) LIKE '%$search%' -- Thêm hàm DATE() để so sánh ngày
GROUP BY 
    c.FullName, c.Address, c.Email, c.Phone, o.OrderDate, o.Status, o.OrderID, o.CustomerID
ORDER BY 
    o.OrderDate DESC, 
    CASE WHEN o.Status = 'Pending' THEN 0 ELSE 1 END ASC;";
          } else {
            $query = "SELECT
    c.FullName AS CustomerName,
    c.Address,
    c.Email,
    c.Phone,
    o.OrderDate,
    GROUP_CONCAT(p.Name SEPARATOR ', ') AS ProductsOrdered,
    SUM(od.Quantity * p.Price) AS TotalAmount,
    o.Status,
    o.OrderID,
    o.CustomerID
FROM 
    Orders o
LEFT JOIN 
    Customer c ON c.CustomerID = o.CustomerID
JOIN 
    OrderDetails od ON o.OrderID = od.OrderID
JOIN 
    Products p ON od.ProductID = p.ProductID
GROUP BY 
    o.OrderID, c.FullName, c.Address, c.Email, c.Phone, o.OrderDate, o.Status, o.CustomerID  -- Thêm các trường vào GROUP BY để đảm bảo tính hợp lệ của truy vấn
ORDER BY 
    CASE WHEN o.Status = 'Pending' THEN 0 ELSE 1 END ASC,
    o.OrderDate DESC";
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
                  <td>
                    <a href='/BnL/admin/orderdetails&id=<?php echo $item['OrderID']; ?>'>
                      <?php echo $count; ?>
                    </a>
                  </td>
                  <td><?php echo $item['CustomerName']; ?></td>
                  <td><?php echo $item['Address']; ?></td>
                  <td><?php echo $item['Email']; ?></td>
                  <td><?php echo $item['Phone']; ?></td>
                  <td><?php echo $item['OrderDate']; ?></td>
                  <td>
                    <form method="POST" action="/BnL/admin/orders_status">
                      <input type="hidden" name="orderId" value="<?php echo $item['OrderID']; ?>">
                      <input type="hidden" name="customerId" value="<?php echo $item['CustomerID']; ?>">
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
  </div>
</body>

</html>

<?php layouts('footer_dashboard'); ?>