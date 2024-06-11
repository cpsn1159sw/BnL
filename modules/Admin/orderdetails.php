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

if(isGet()) {
    $filterAll = filter();
    if (!empty($filterAll['id'])) {
        $orderId = $filterAll['id'];
        $info = getRows("SELECT c.FullName AS CustomerName,
                                c.Address,
                                c.Email,
                                c.Phone,
                                o.OrderDate,
                                GROUP_CONCAT(p.Name) AS ProductsOrdered,
                                SUM(od.Quantity * p.Price) AS TotalAmount,
                                o.Status
                        FROM 
                            Orders o
                        LEFT JOIN 
                            Customer c ON c.CustomerID = o.CustomerID
                        JOIN 
                            OrderDetails od ON o.OrderID = od.OrderID
                        JOIN 
                            Products p ON od.ProductID = p.ProductID
                        WHERE o.OrderID = $orderId
                        GROUP BY 
                            c.FullName, c.Address, c.Email, c.Phone, o.OrderDate, o.Status
                        ORDER BY 
                            o.OrderDate DESC");
        setSession('orderdetails', $info);
    }                    
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');

?>

<!doctype html>
<html lang="en">

<head>
  <title>BnL - Order Details</title>
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

<body id="body">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="panel-title">Order Details</h2>
        </div>
        <div class="panel-body">
            <?php
            if (!empty($smg)) {
                getSmg($smg, $smg_type);
            }
            $od = getSession('orderdetails');
                foreach ($od as $item) :
            ?>
            <form class="text-left clearfix" action="" method="post">
                <div class="row">
                    <div class="col">
                        <label for="">Customer Information</label>
                        <div class="form-group">
                            <span>Name: </span><?php echo $item['CustomerName']; ?>
                        </div>
                        <div class="form-group">
                            <span>Address: </span><?php echo $item['Address']; ?>
                        </div>
                        <div class="form-group">
                            <span>Email: </span><?php echo $item['Email']; ?>
                        </div>
                        <div class="form-group">
                            <span>Phone: </span><?php echo $item['Phone']; ?>
                        </div>
                    </div>
                    <div class="col">
                        <label for="">Order Date</label>
                        <div class="form-group">
                            <?php echo $item['OrderDate']; ?>
                        </div>
                        <label for="">Products Ordered</label>
                        <div class="form-group">
                            <?php echo $item['ProductsOrdered']; ?>
                        </div>
                        <label for="">Total</label>
                        <div class="form-group">
                            <?php echo $item['TotalAmount']; ?>
                        </div>
                        <label for="">Status</label>
                        <div class="form-group">
                            <?php echo $item['Status']; ?>
                        </div>
                    </div>
                </div>           
                <?php  
                endforeach;                                  
                ?>
                <a href="/BnL/admin/orders" class="btn btn-primary">Back</a>
            </form>

        </div>
    </div>
</body>