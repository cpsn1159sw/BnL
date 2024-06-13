<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
  die('Access denied...');
}
$data = [
  'pageTitle' => 'BnL - Cart'
];
layouts('header_login', $data);
if (!isLogin()) {
  setFlashData('smg', 'You need to log in to your account first');
  setFlashData('smg_type', 'danger');
  redirect('/BnL/user/logout');
} else {
  $filterAll = filter();
  if (!empty($filterAll['id'])) {
    $customerID = $filterAll['id'];
    $dataInsertO = [
      'CustomerID' => $filterAll['customerID'],
      'Status' => 'Pending',
      'TotalAmount' => 'Pending',
      'OrderDate' => date('Y-m-d H:i:s')
    ];

    $insertStatusO = insert('orders', $dataInsertO);

    // $info = getRows("SELECT * FROM cart WHERE ProductID = $productID");
    // if ($info > 0) {
    //   $deleteA = delete('cart', "ProductID = $productID");
    //   if ($deleteA) {
    //     setFlashData('smg', 'Remove successful!');
    //     setFlashData('smg_type', 'success');
    //   } else {
    //     setFlashData('smg', 'The system is experiencing issues. Please try again later!');
    //     setFlashData('smg_type', 'danger');
    //   }
    // }
    // redirect('/BnL/public/cart');
  }
}

?>
<section class="page-wrapper success-msg">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <i class="tf-ion-android-checkmark-circle"></i>
          <h2 class="text-center">Thank you! For your payment</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, sed.</p>
          <a href="shop" class="btn btn-main mt-20">Continue Shopping</a>
        </div>
      </div>
    </div>
  </div>
</section><!-- /.page-warpper -->
<?php layouts('footer'); ?>