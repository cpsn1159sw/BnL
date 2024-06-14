<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
  die('Access denied...');
}

if (!isLoginA() || (role() != 'Admin' && role() != 'Staff')) {
  setFlashData('smg', 'You do not have permission to access this page and have been logged out!');
  setFlashData('smg_type', 'danger');
  getSmg($smg, $smg_type);
  redirect('admin/logout');
}

$search = '';
$selectedCategory = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['search'])) {
    $search = $_POST['search'];
  }

  if (isset($_POST['category'])) {
    $selectedCategory = $_POST['category'];
  }
}

$categories = getRows("SELECT * FROM categories");

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
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
    .form-select, .form-control {
      width: 100%;
    }
    .out-of-stock {
      background-color: #f8d7da;
    }
  </style>
</head>
<body>
  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar" class="active">
      <h1><a href="<?php echo _WEB_HOST?>/public/home" target="_blank" class="logo">BnL</a></h1>
      <ul class="list-unstyled components mb-5">
        <li><a href="home"><span class="tf-ion-ios-home"></span> Home</a></li>
        <li><a href="hrm"><span class="tf-ion-android-people"></span> HRM</a></li>
        <li class="active"><a href="products"><span class="tf-basket"></span> Products</a></li>
        <li><a href="customers"><span class="tf-ion-android-contacts"></span> Customers</a></li>
        <li><a href="orders"><span class="tf-ion-tshirt"></span> Orders</a></li>
      </ul>
    </nav>
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
                  $adminQuery = oneRow("SELECT administrator.email, administrator.role FROM administrator INNER JOIN logintokena ON administrator.adminid = logintokena.adminid WHERE logintokena.token = '" . getSession('logintokena') . "'");
                  $email = $adminQuery['email'];
                  $role = $adminQuery['role'];
                  $parts = explode("@", $email);
                  $username = $parts[0];
                  echo $username . ' (' . $role . ')';	
                ?>
                <span class="tf-ion-ios-arrow-down"></span>
                <ul class="dropdown-menu ml-0">
                  <li><a href="admin/create">Create Account</a></li>
                  <li><a href="admin/reset_login">Reset Password</a></li>
                  <li><a href="admin/logout">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </div>
      <h2 class="mb-4">BnL Products</h2>
      <p><a href="products/create" class="btn btn-success">Add product <span class="tf-ion-plus"></span></a></p>
      <div class="row">
        <div class="col-lg-2">
          <form method="POST" action="">
            <label for="category" class="form-label">Categories:</label>
            <select name="category" class="form-select" onchange="this.form.submit()">
              <option value="">Select a category</option>
              <?php 
              foreach ($categories as $category) :
                $selected = ($category['Name'] == $selectedCategory) ? 'selected' : '';
              ?>
                <option value='<?php echo htmlspecialchars($category['Name'], ENT_QUOTES, 'UTF-8'); ?>' <?php echo $selected ?>><?php echo htmlspecialchars($category['Name'], ENT_QUOTES, 'UTF-8'); ?></option>
              <?php endforeach; ?>
            </select>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <form action="" method="post" class="mt-3 mb-lg-3">
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($selectedCategory, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="search" name="search" value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
      <?php
      if (!empty($smg)) {
        getSmg($smg, $smg_type);
      }
      ?>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th width="2%">ID</th>
              <th>Product Name</th>
              <th>Description</th>
              <th>Price</th>
              <th width="2%">Size</th>
              <th>Stock Quantity</th>
              <th>Image</th>
              <th width="5%">Edit</th>
              <th width="5%">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            if (!empty($selectedCategory)) {
              $query = "SELECT p.* FROM products p INNER JOIN categories c ON c.CategoryID = p.CategoryID WHERE c.Name = '$selectedCategory'";
              
              if (!empty($search)) {
                $query .= " AND p.Name LIKE '%$search%'";
              } 
              
              $list = getRows($query);

              if (!empty($list)) :
                $count = 0;
                foreach ($list as $item) :
                  $count++;
                  $rowClass = $item['StockQuantity'] == 0 ? 'out-of-stock' : '';
            ?>
                  <tr class="<?php echo $rowClass; ?>">
                    <td><?php echo $count; ?></td>
                    <td><?php echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['Description'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['Price'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['Size'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['StockQuantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><img src="<?php echo htmlspecialchars(_WEB_HOST_TEMPLATES . $item['imageURL'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8'); ?>" width="100"></td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="products/edit&id=<?php echo $item['ProductID']; ?>" class="btn btn-warning"><i class="tf-ion-edit" aria-hidden="true"></i></a>
                      </div>
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="products/delete&id=<?php echo $item['ProductID']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger"><i class="tf-ion-trash-b" aria-hidden="true"></i></a>
                      </div>
                    </td>
                  </tr>
                <?php
                endforeach;
              else :
                ?>
                <tr>
                  <td colspan="9">
                    <div class="alert alert-danger text-center">No products found</div>
                  </td>
                </tr>
              <?php
              endif;
            } else {
              $query = "SELECT p.* FROM products p INNER JOIN categories c ON c.CategoryID = p.CategoryID";
              
              if (!empty($search)) {
                $query .= " WHERE p.Name LIKE '%$search%'";
              } 
              $query .= " ORDER BY p.StockQuantity ASC;";
              $list = getRows($query);

              if (!empty($list)) :
                $count = 0;
                foreach ($list as $item) :
                  $count++;
                  $rowClass = $item['StockQuantity'] == 0 ? 'out-of-stock' : '';
            ?>
                  <tr class="<?php echo $rowClass; ?>">
                    <td><?php echo $count; ?></td>
                    <td><?php echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['Description'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['Price'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['Size'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['StockQuantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><img src="<?php echo htmlspecialchars(_WEB_HOST_TEMPLATES . $item['imageURL'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8'); ?>" width="100"></td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="products/edit&id=<?php echo $item['ProductID']; ?>" class="btn btn-warning"><i class="tf-ion-edit" aria-hidden="true"></i></a>
                      </div>
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="products/delete&id=<?php echo $item['ProductID']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger"><i class="tf-ion-trash-b" aria-hidden="true"></i></a>
                      </div>
                    </td>
                  </tr>
                <?php
                endforeach;
              else :
                ?>
                <tr>
                  <td colspan="9">
                    <div class="alert alert-danger text-center">No products found</div>
                  </td>
                </tr>
              <?php
              endif;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>

<?php layouts('footer_dashboard'); ?>
