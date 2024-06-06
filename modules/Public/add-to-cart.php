<?php
// Kiểm tra xem session đã bắt đầu chưa
if (session_status() == PHP_SESSION_NONE) {
    // Nếu session chưa được bắt đầu, bắt đầu một session mới
    session_start();
}
if(isGet()) {
$filterAll = filter();
if (!empty($filterAll['id'])) {
    $productId = $filterAll['id'];
    $info = getRows("SELECT * FROM products WHERE ProductID = '$productId'");
    setSession('cart', $info);
    }
                
}

        





print_r($productId);
echo "Thông tin của session 'cart':<br>";
var_dump(getSession('cart'));

?>
