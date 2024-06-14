<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

$data = [
    'pageTitle' => 'BnL - My order history '
];

if (isLogin()) {
    layouts('header_login', $data);
} else {
    setFlashData('smg', 'Please login to your account first!');
    setFlashData('smg_type', 'danger');
    getSmg($smg, $smg_type);
    redirect('user/login');
}

?>
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">My order history</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo _WEB_HOST?>/public/home">Home</a></li>
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
<style>
    .user-dashboard {
        margin-bottom: 30px !important;
    }
</style>

<body id="body">
    <section class="user-dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-wrapper user-dashboard">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tokenLogin = getSession('logintokenc');
                                    $query = oneRow("SELECT CustomerID FROM logintokenc WHERE Token = '$tokenLogin'");
                                    $CustomerID = $query['CustomerID'];
                                    $list = getRows("SELECT * FROM orders WHERE CustomerID = $CustomerID ORDER BY OrderDate DESC");
                                    if (!empty($list)) :
                                        $count = 0;
                                        foreach ($list as $item) :
                                            $count++;
                                    ?>
                                            <tr>
                                                <td><?php echo $item['OrderID']; ?></td>
                                                <td><?php echo $item['OrderDate']; ?></td>
                                                <td><?php echo $item['TotalAmount']; ?> $</td>
                                                <?php 
                                                if($item['Status'] == 'Pending') {
                                                    echo '<td><span class="label label-warning">'.$item['Status'].'</span></td>';
                                                }
                                                if($item['Status'] == 'Delivered') {
                                                    echo '<td><span class="label label-success">'.$item['Status'].'</span></td>';
                                                } 
                                                if($item['Status'] == 'Cancelled') {
                                                    echo '<td><span class="label label-danger">'.$item['Status'].'</span></td>';
                                                }
                                                ?>
                                                <td><a href="orderdetails&id=<?php echo $item['OrderID']; ?>" class="btn btn-default">View</a></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    else :
                                        ?>
                                        <tr>
                                            <td colspan="5">
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
            </div>
        </div>
    </section>
</body>
<?php
// End output buffering and flush the output
layouts("footer");
?>

</html>