<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

// Start output buffering to prevent header issues
ob_start();


function getLoggedInCustomerID() {
    $tokenLogin = getSession('logintokenc');
    $queryToken = oneRow("SELECT CustomerID FROM logintokenc WHERE token = '$tokenLogin'");
    return !empty($queryToken) ? $queryToken['CustomerID'] : null;
}

if (!isLogin()) {
    // Redirect to login page if not logged in
    header('Location: /BnL/public/login');
    exit();
}

$customerID = getLoggedInCustomerID();
if ($customerID === null) {
    // If somehow CustomerID is still null, handle it
    header('Location: /BnL/public/login');
    exit();
}

$data = [
    'pageTitle' => 'BnL - My order history '
];

layouts(isLogin() ? 'header_login' : 'header', $data);
?>
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">My order history</h1>
                    <ol class="breadcrumb">
                        <li><a href="/BnL/public/home">Home</a></li>
                        <li class="active">My order history</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
if (!empty($smg)) {
    getSmg($smg, $smg_type);
}
?>

<body id="body">
    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th width="2%">ID</th>
                    <th>Order Date</th>
                    <th>Status</th>
                </thead>
                <?php


                    // Query to get order history for the logged-in customer
                    $query = "SELECT 
                                    o.OrderID,
                                    o.OrderDate,
                                    o.Status
                            FROM 
                                Orders o
                            WHERE
                                o.CustomerID = :customerID
                            ORDER BY 
                                o.OrderDate DESC";
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
                                        <?php echo $item['OrderID']; ?>
                                    </a>
                                </td>
                                <td><?php echo $item['OrderDate']; ?></td>
                                <td><?php echo $item['Status']; ?></td>
                            </tr>
                    <?php
                        endforeach;
                    else :
                    ?>
                        <tr>
                            <td colspan="3">No orders found</td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</body>
<?php var_dump($list); // Check if $list is populated with data?>

</html>
<?php
// End output buffering and flush the output
layouts("footer");
ob_end_flush();
?>
