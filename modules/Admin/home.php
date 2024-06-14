<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
  die('Access denied...');
}

if (isLoginA() && role() == 'Admin') {
} else {
  setFlashData('smg', 'You do not have permission to access this page and have been logged out!');
  setFlashData('smg_type', 'danger');
  getSmg($smg, $smg_type);
  redirect(_WEB_HOST.'/admin/logout');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>BnL - Home</title>
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
      <h1><a href="<?php echo _WEB_HOST?>/public/home" target="_blank" class="logo">BnL</a></h1>
      <ul class="list-unstyled components mb-5">
        <li class="active">
          <a href="<?php echo _WEB_HOST?>/admin/home"><span class="tf-ion-ios-home"></span> Home</a>
        </li>
        <li class="">
          <a href="<?php echo _WEB_HOST?>/admin/hrm"><span class="tf-ion-android-people"></span> HRM</a>
        </li>
        <li class="">
          <a href="<?php echo _WEB_HOST?>/admin/products"><span class="tf-basket"></span> Products</a>
        </li>
        <li class="">
          <a href="<?php echo _WEB_HOST?>/admin/customers"><span class="tf-ion-android-contacts"></span> Customers</a>
        </li>
        <li class="">
          <a href="<?php echo _WEB_HOST?>/admin/orders"><span class="tf-ion-tshirt"></span> Orders</a>
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
                <ul class="dropdown-menu">
                  <li><a href="<?php echo _WEB_HOST?>/admin/create">Create Account</a></li>
                  <li><a href="<?php echo _WEB_HOST?>/admin/reset_login">Reset Password</a></li>
                  <li><a href="<?php echo _WEB_HOST?>/admin/logout">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </div>

      <!-- Nội dung của dashboard -->
      <h2 class="mb-4">Home</h2>
      <?php
      $list1 = getRows("SELECT p.Name AS ProductName, SUM(od.Quantity) AS TotalQuantity
      FROM OrderDetails od
      INNER JOIN products p ON p.ProductID = od.ProductID
      INNER JOIN Orders o ON o.OrderID = od.OrderID
      WHERE o.Status = 'Delivered'
      GROUP BY p.Name;");

      $list2 = getRows("SELECT c.Name AS CategoryName, SUM(od.Quantity) AS TotalQuantity
      FROM Products p
      INNER JOIN Categories c ON p.CategoryID = c.CategoryID
      INNER JOIN OrderDetails od ON p.ProductID = od.ProductID
      INNER JOIN Orders o ON o.OrderID = od.OrderID
      WHERE o.Status = 'Delivered'
      GROUP BY c.Name;");

      $selectedYear = isset($_GET['y']) ? $_GET['y'] : date('Y');

      // Truy vấn cơ sở dữ liệu để lấy doanh thu theo tháng trong năm đã chọn
      $query = getRows("SELECT  DATE_FORMAT(OrderDate, '%Y') AS Year, DATE_FORMAT(o.OrderDate, '%m') AS Month, SUM(o.TotalAmount) AS Revenue
      FROM Orders o
      WHERE o.Status = 'Delivered' AND YEAR(o.OrderDate) = '$selectedYear'
      GROUP BY DATE_FORMAT(o.OrderDate, '%m')");
      ?>

      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <div class="row">
        <div class="col">
          <div id="columnChart" style="width: 100%; height: 400px;"></div>
        </div>
        <div class="col">
          <div id="circleChart" style="width:100%; max-width:600px; height:400px;"></div>
        </div>
      </div>
      <style>
  @media screen and (max-width: 500px) {
    .this {
      overflow-x: auto;
    }
  }
</style>

      <div class="row this">
        <div class="col-lg-6">
          <label for="yearSelect" class="form-label">Select Year:</label>
          <select id="yearSelect" class="form-select">
            <?php
            // Loop through years from 2023 to the current year
            for ($year = date('Y'); $year >= 2023; $year--) {
              $selected = ($year == $selectedYear) ? 'selected' : '';
              echo "<option value='$year' $selected>$year</option>";
            }
            ?>
          </select>
        </div>
        <div id="chart_div" style="width: 100%; height: 400px;"></div>
      </div>

    </div>
  </div>
</body>

<?php layouts('footer_dashboard'); ?>
<script>
  google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart1);
  google.charts.setOnLoadCallback(drawChart2);
  google.charts.setOnLoadCallback(function() {
    drawChart3(<?php echo $selectedYear; ?>);
  });

  function drawChart1() {
    // Chuyển đổi dữ liệu PHP sang dữ liệu JavaScript
    var list1 = <?php echo json_encode($list1); ?>;

    // Kiểm tra dữ liệu trước khi chuyển đổi thành DataTable
    if (list1.length === 0) {
        document.getElementById('columnChart').innerHTML = '<p>No data</p>';
        return;
    }

    // Chuẩn bị dữ liệu để vẽ biểu đồ
    var dataArray = [['Product', 'Total Quantity']];
    list1.forEach(function(row) {
        dataArray.push([row.ProductName, parseInt(row.TotalQuantity)]);
    });

    var data = google.visualization.arrayToDataTable(dataArray);

    var options = {
        title: 'Top Products by Quantity Sold',
        titleTextStyle: {
            fontSize: 18,
            bold: true
        },
        legend: {
            position: 'none'
        },
        hAxis: {
            title: 'Product'
        },
        vAxis: {
            title: 'Total Quantity'
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('columnChart'));
    chart.draw(data, options);
}

// Đảm bảo rằng Google Charts đã tải xong rồi mới vẽ biểu đồ
google.charts.setOnLoadCallback(drawChart1);


  function drawChart2() {
    const data = google.visualization.arrayToDataTable([
      ['Category', 'Total Quantity'],
      <?php foreach ($list2 as $row) : ?>['<?php echo $row['CategoryName']; ?>', <?php echo $row['TotalQuantity']; ?>],
      <?php endforeach; ?>
    ]);

    if (data.length === 0) {
      document.getElementById('circleChart').innerHTML = '<p>No data available</p>';
      return;
    }

    const options = {
      title: 'Purchase Quantity by Category',
      titleTextStyle: {
        fontSize: 18,
        bold: true
      },
      legend: {
        position: 'right'
      }
    };

    const chart = new google.visualization.PieChart(document.getElementById('circleChart'));
    chart.draw(data, options);
  }



  function drawChart3(year) {
    var rawData = <?php echo json_encode($query); ?>;
    var filteredData = rawData.filter(function(item) {
      return item.Year == year;
    });

    if (filteredData.length === 0) {
      document.getElementById('chart_div').innerHTML = '<p>No data available</p>';
      return;
    }

    // Format data
    var data = google.visualization.arrayToDataTable([
      ['Month', 'Revenue'],
      ...filteredData.map(item => [{
        v: parseInt(item.Month),
        f: 'Month: ' + parseInt(item.Month)
      }, {
        v: parseFloat(item.Revenue),
        f: parseFloat(item.Revenue).toFixed(2) + '$'
      }])
    ]);

    var options = {
      title: 'Revenue Over Time in ' + year,
      titleTextStyle: {
        fontSize: 18,
        bold: true
      },
      curveType: 'function',
      legend: {
        position: 'right'
      },
      hAxis: {
        titleTextStyle: {
          fontSize: 18,
        },
        title: 'Month',
        ticks: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
      },
      vAxis: {
        titleTextStyle: {
          fontSize: 16,
        },
        title: 'Revenue',
        format: '#,##0.00$'
      }
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }

  document.getElementById('yearSelect').addEventListener('change', function() {
    var selectedYear = this.value;
    window.location.href = window.location.pathname + '?y=' + selectedYear;
  });
</script>

</html>