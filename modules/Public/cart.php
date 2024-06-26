<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

$data = [
    'pageTitle' => 'BnL - Cart'
];

if (!isLogin()) {
    layouts('header', $data);
} else {
    layouts('header_login', $data);
}

// Lấy thông tin thông báo từ session
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">Cart</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo _WEB_HOST?>/public/home">Home</a></li>
                        <li class="active">Cart</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
// Hiển thị thông báo nếu có
if (!empty($smg)) {
    getSmg($smg, $smg_type);
}
?>

<div class="page-wrapper">
    <div class="cart shopping">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="block">
                        <div class="product-list">
                            <?php
                            // Lấy giỏ hàng hiện tại từ db
                            $tokenLogin = getSession('logintokenc');
                            $cartlist = getRows("SELECT * FROM cart WHERE Token = '$tokenLogin'");
                            $total = oneRow("SELECT ROUND(SUM(Quantity * Price - (Price * Quantity * Discount / 100)), 2) AS Total
                                FROM cart WHERE Token = '$tokenLogin'");
                            $query = oneRow("SELECT CustomerID FROM logintokenc WHERE Token = '$tokenLogin'");
                            // Group products by ID
                            $groupedProducts = [];
                            foreach ($cartlist as $item) {
                                if (isset($groupedProducts[$item['ProductID']])) {
                                    $groupedProducts[$item['ProductID']]['Quantity'] += $item['Quantity'];
                                } else {
                                    $groupedProducts[$item['ProductID']] = $item;
                                }
                            }
                            if (!empty($groupedProducts)) :
                            ?>
                                <form method="post" action="cart-update">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="">Item Name</th>
                                                    <th class="">Item Price</th>
                                                    <th class="">Discount</th>
                                                    <th class="">Quantity</th>
                                                    <th class="">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($groupedProducts as $item) : ?>
                                                    <tr>
                                                        <td>
                                                            <div class="product-info">
                                                                <img width="80" src="<?php echo _WEB_HOST_TEMPLATES . $item['Image']; ?>" alt="" class="img-responsive" />
                                                                <?php echo $item['Name']; ?>
                                                            </div>
                                                        </td>
                                                        <td><?php echo $item['Price']; ?></td>
                                                        <td><?php echo $item['Discount']; ?></td>
                                                        <td>
                                                            <!-- Input for quantity with product ID and current quantity -->
                                                            <input style="width: 80px;" name="quantity[<?php echo $item['ProductID']; ?>]" type="number" value="<?php echo $item['Quantity']; ?>" min="1"> <button type="submit" name="update_item" value="<?php echo $item['ProductID']; ?>" class="btn btn-warning">Update</button>
                                                        </td>
                                                        <td>                                                      
                                                            <!-- Remove link with confirmation -->
                                                            <a class="product-remove" onclick="return confirm('Are you sure you want to remove?')" href="<?php echo _WEB_HOST?>/public/cart-remove?id=<?php echo $item['ProductID']; ?>">Remove</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h3>Total: <?php echo $total['Total'];?>$</h3>
                                    <a href="<?php echo _WEB_HOST?>/public/checkout?id=<?php echo $query['CustomerID']; ?>" class="btn btn-main pull-right">Checkout</a>
                                </form>
                            <?php else : ?>
                                <section class="empty-cart page-wrapper">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="block text-center">
                                                <i class="tf-ion-ios-cart-outline"></i>
                                                <h2 class="text-center">Your cart is currently empty.</h2>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, sed.</p>
                                                <a href="<?php echo _WEB_HOST?>/public/shop" class="btn btn-main mt-20">Return to shop</a>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php layouts('footer'); ?>
