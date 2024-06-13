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
  <title>BnL - Customers</title>
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
    .table td, .table th {
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
        <li class="active">
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
      <h2 class="mb-4">Customer</h2>
      <?php
      if (!empty($smg)) {
        getSmg($smg, $smg_type);
      }
      ?>
      <p><a href="/BnL/customers/create" target="_blank" class="btn btn-success">Add user <span class="tf-ion-plus"></span></a></p>
      <form action="" method="post" class="mt-3 mb-lg-3">
        <input type="search" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control" placeholder="Search...">
      </form>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Full name</th>
              <th>Address</th>
              <th>Email</th>
              <th>Phone</th>
              <th width="10%">Status</th>
              <th width="5%">Edit</th>
              <th width="5%">Delete</th>
            </tr>
          </thead>
          <tbody>
          <?php
          if (!empty($search)) {
            $query = "SELECT * FROM customer 
                      WHERE FullName LIKE '%$search%' OR Email LIKE '%$search%' OR Phone LIKE '%$search%'
                      ORDER BY update_at";
          } else {
            $query = "SELECT * FROM customer ORDER BY update_at";
          }
          $list = getRows($query);
          if (!empty($list)) :
            $count = 0;
            foreach ($list as $item) :
                $count++;
          ?>
                <tr>
                  <td><?php echo $count; ?></td>
                  <td><?php echo htmlspecialchars($item['FullName'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($item['Address'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($item['Email'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($item['Phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo $item['Status'] == 1 ? '<span class="btn btn-success btn-sm">Active</span>' : '<span class="btn btn-danger btn-sm">None Active</span>'; ?></td>
                  <td>
                    <div class="btn-group" role="group">
                      <a href="/BnL/customers/edit&id=<?php echo $item['CustomerID']; ?>" class="btn btn-warning"><i class="tf-ion-edit" aria-hidden="true"></i></a>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group" role="group">
                      <a href="/BnL/customers/delete&id=<?php echo $item['CustomerID']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger"><i class="tf-ion-trash-b" aria-hidden="true"></i></a>
                    </div>
                  </td>
                </tr>
            <?php
            endforeach;
          else :
            ?>
            <tr>
              <td colspan="8">
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
