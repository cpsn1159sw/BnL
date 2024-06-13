<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}

// Kiểm tra vai trò đăng nhập
if (isLoginA() && (role() == 'Admin' || role() == 'Staff')) {

    $filterAll = filter();
    if(!empty($filterAll['id'])) {
        $productID = $filterAll['id'];

        $info = oneRow("SELECT * FROM products WHERE ProductID = '$productID'");
        if(!empty($info)) {
            setFlashData('info', $info);
        } else {
            redirect('/BnL/admin/products');
        }
    }

    if (isPost()) {
        $filterAll = filter();
        $errors = []; // Mảng chứa các lỗi

        // Validate 
        if (empty($filterAll['pro_name'])) {
            $errors['pro_name']['required'] = '*Please enter product name.';
        }

        // Validate 
        if (empty($filterAll['description'])) {
            $errors['description']['required'] = '*Please enter product description.';
        }

        // Validate 
        if (empty($filterAll['price'])) {
            $errors['price']['required'] = '*Please enter product price.';
        } else {
            if(!isNumberFloat($filterAll['price'])){
              $errors['price']['number'] = '*Please enter the number.';
            }
        }

        // Validate 
        if (empty($filterAll['size'])) {
            $errors['size']['required'] = '*Please enter product size.';
        }

        // Validate 
        if (empty($filterAll['Stock_Quantity'])) {
            $errors['Stock_Quantity']['required'] = '*Please enter product stock quantity.';
        }

        if (empty($errors)) {
            $dataUpdate = [
                'Name' => $filterAll['pro_name'],
                'Description' => $filterAll['description'],
                'Price' => $filterAll['price'],
                'Size' => $filterAll['size'],
                'StockQuantity' => $filterAll['Stock_Quantity']
            ];

            $condition = "ProductID = $productID";
            $insertStatus = update('products', $dataUpdate, $condition); // NHỚ ĐỔI LẠI TÊN BẲNG customer SAU NÀY 
            if ($insertStatus) {
                setFlashData('smg', 'Update successful!');
                setFlashData('smg_type', 'success');
            } else {
                setFlashData('smg', 'The system is experiencing issues. Please try again later!');
                setFlashData('smg_type', 'danger');
            }
        } else {
            setFlashData('smg', 'Please check the information again!');
            setFlashData('smg_type', 'danger');
            setFlashData('errors', $errors);
            setFlashData('old', $filterAll);
        }
        redirect('/BnL/products/edit&id='.$productID);
    }
} else {
    setFlashData('smg', 'You do not have permission to access this page and have been logged out!');
    setFlashData('smg_type', 'danger');
    getSmg($smg, $smg_type);
    redirect('/BnL/admin/logout');
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$info = getFlashData('info');
if(!empty($info)) {
    $old = $info;
}
?>

<title>BnL - Product Edit</title>

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

<body id="body">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="panel-title">Edit product information</h2>
        </div>
        <div class="panel-body">
            <?php
            if (!empty($smg)) {
                getSmg($smg, $smg_type);
            }
            ?>
            <form class="text-left clearfix" action="" method="post">
                <div class="form-group">
                    <input name="pro_name" type="text" class="form-control" placeholder="Product Name" value="<?php echo old_data('Name', $old) ?>">
                    <?php
                    echo form_error('pro_name', '<span class="er">', '</span>', $errors);
                    ?>
                </div>
                <div class="form-group">
                    <input name="description" type="text" class="form-control" placeholder="Description" value="<?php echo old_data('Description', $old) ?>">
                    <?php
                    echo form_error('description', '<span class="er">', '</span>', $errors);
                    ?>
                </div>
                <div class="form-group">
                    <input name="price" type="text" class="form-control" placeholder="Price" value="<?php echo old_data('Price', $old) ?>">
                    <?php
                    echo form_error('price', '<span class="er">', '</span>', $errors);
                    ?>
                </div>
                <div class="form-group">
                    <input name="size" type="text" class="form-control" placeholder="Size" value="<?php echo old_data('Size', $old) ?>">
                    <?php
                    echo form_error('size', '<span class="er">', '</span>', $errors);
                    ?>
                </div>
                <div class="form-group">
                    <input name="Stock_Quantity" type="number" class="form-control" placeholder="Stock Quantity" value="<?php echo old_data('StockQuantity', $old) ?>">
                    <?php
                    echo form_error('Stock_Quantity', '<span class="er">', '</span>', $errors);
                    ?>
                </div>
                <input type="hidden" name="id" value="<?php echo $productID; ?>">
                <a href="/BnL/admin/products" class="btn btn-primary">Back</a> <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</body>