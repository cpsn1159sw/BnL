<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}

$data = [
    'pageTitle' => 'Cart'
];

if (!isLogin()) {
    setFlashData('smg', 'You need to log in to your account first ');
    setFlashData('smg_type', 'danger');
    getSmg($smg, $smg_type);
    redirect('/BnL/user/login');
}

if (!isLogin()) {
    layouts('header', $data);
} else {
    layouts('header_login', $data);
}

?>

<body>
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Cart</h1>
                        <ol class="breadcrumb">
                            <li><a href="home">Home</a></li>
                            <li><a href="shop">Shop</a></li>
                            <li class="active">Cart</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="page-wrapper">
        <div class="cart shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="block">
                            <div class="product-list">
                                <form method="post">
                                    <table class="table">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php

                                        $total_price = 0;
                                        $cart = getSession('cart');
                                        if (!empty($cart)) :
                                            foreach ($cart as $item) :
                                                $total = $item['Price'] * $item['Quantity'];
                                                $total_price += $total;
                                        ?>
                                                <tr>
                                                    <td><?php echo $item['Name']; ?></td>
                                                    <td>$<?php echo $item['Price']; ?></td>
                                                    <td><?php echo $item['Quantity']; ?></td>
                                                    <td>$<?php echo $total; ?></td>
                                                    <td><a href="/BnL/public/remove-from-cart&id=<?php echo $item["ProductID"]; ?>">Remove</a></td>
                                                </tr>
                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                        <tr>
                                            <td colspan="3"><strong>Total</strong></td>
                                            <td colspan="2">$<?php echo $total_price; ?></td>
                                        </tr>
                                    </table>
                                    <a href="/BnL/public/checkout" class="btn btn-main pull-right">Checkout</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php layouts('footer'); ?>
</body>

</html>