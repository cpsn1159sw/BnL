<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
  die('Access denied...');
}

if (isLogin()) {

} else {
  setFlashData('smg', 'You need to login your account first!');
  setFlashData('smg_type', 'danger');
  getSmg($smg, $smg_type);
  redirect(_WEB_HOST.'/user/login');
}

if(isGet()) {
    $filterAll = filter();
    if (!empty($filterAll['id'])) {
        $orderId = $filterAll['id'];
        $infoCus = getRows("SELECT c.FullName AS CustomerName,
                                c.Address,
                                c.Email,
                                c.Phone,
                                o.OrderDate,
                                o.TotalAmount AS TotalAmount,
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
                            c.FullName, c.Address, c.Email, c.Phone, o.OrderDate, o.Status");
        $infoOD = getRows("SELECT p.Name AS ProductsOrdered,
                                  od.Quantity,
                                  p.Price AS UnitPrice
                            FROM 
                                Orders o
                            JOIN 
                                OrderDetails od ON o.OrderID = od.OrderID
                            JOIN 
                                Products p ON od.ProductID = p.ProductID
                            WHERE o.OrderID = $orderId");
        setSession('customer', $infoCus);                  
        setSession('orderdetails', $infoOD);
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
            $cus = getSession('customer');

            // Group products by name
            $groupedProducts = [];
            foreach ($od as $odItem) {
                if (isset($groupedProducts[$odItem['ProductsOrdered']])) {
                    $groupedProducts[$odItem['ProductsOrdered']]['Quantity'] += $odItem['Quantity'];
                } else {
                    $groupedProducts[$odItem['ProductsOrdered']] = $odItem;
                }
            }

            foreach ($cus as $cusItem) :
            ?>
            <form class="text-left clearfix" action="" method="post">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="">Customer Information</label>
                        <div class="form-group">
                            <span>Name: </span><?php echo $cusItem['CustomerName']; ?>
                        </div>
                        <div class="form-group">
                            <span>Address: </span><?php echo $cusItem['Address']; ?>
                        </div>
                        <div class="form-group">
                            <span>Email: </span><?php echo $cusItem['Email']; ?>
                        </div>
                        <div class="form-group">
                            <span>Phone: </span><?php echo $cusItem['Phone']; ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="">Order Date</label>
                        <div class="form-group">
                            <?php echo $cusItem['OrderDate']; ?>
                        </div>
                        <label for="">Products Ordered</label>
                        <div class="form-group">
                        <table class="table table-bordered" id="">
                            <thead>
                                <td width="5%">Product Name</td>
                                <td width="3%">Quantity</td>
                                <td width="3%">Unit Price</td>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($groupedProducts as $product) :
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['ProductsOrdered'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($product['Quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($product['UnitPrice'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                        </div>
                        <label for="">Total Amount</label>
                        <div class="form-group">
                            <?php echo $cusItem['TotalAmount']; ?>
                        </div>
                        <label for="">Status</label>
                        <div class="form-group">
                            <?php echo $cusItem['Status']; ?>
                        </div>
                    </div>
                </div>           
                <?php  
                endforeach;                            
                ?>
                <a href="<?php echo _WEB_HOST?>/user/order" class="btn btn-primary">Back</a>
            </form>

        </div>
    </div>
</body>

</html>

<?php layouts('footer_dashboard'); ?>
