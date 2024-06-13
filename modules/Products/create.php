<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
  die('Access denied...');
}

// Kiểm tra vai trò đăng nhập
if (isLoginA() && (role() == 'Admin' || role() == 'Staff')) {

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
    if (empty($filterAll['category'])) {
      $errors['category']['required'] = '*Please chose product category.';
    }
    // Validate 
    if (empty($filterAll['Stock_Quantity'])) {
      $errors['Stock_Quantity']['required'] = '*Please enter product stock quantity.';
    }


    if (empty($errors)) {
      $dataInsert = [
        'Name' => $filterAll['pro_name'],
        'Description' => $filterAll['description'],
        'CategoryID' => $filterAll['category'],
        'Price' => $filterAll['price'],
        'Size' => $filterAll['size'],
        'StockQuantity' => $filterAll['Stock_Quantity'],
        'image-url' => $filterAll['']
      ];

      $insertStatus = insert('products', $dataInsert); // NHỚ ĐỔI LẠI TÊN BẲNG customer SAU NÀY 
      if ($insertStatus) {
        setFlashData('smg', 'Add new product unsuccessful!');
        setFlashData('smg_type', 'success');
        redirect('/BnL/admin/products');
      } else {
        setFlashData('smg', 'The system is experiencing issues. Please try again later!');
        setFlashData('smg_type', 'danger');
        redirect('/BnL/products/create');
      }
    } else {
      setFlashData('smg', 'Please check the information again!');
      setFlashData('smg_type', 'danger');
      setFlashData('errors', $errors);
      setFlashData('old', $filterAll);
      redirect('/BnL/products/create');
    }
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
?>

<title>BnL - Add Product</title>

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
          <input name="pro_name" type="text" class="form-control" placeholder="Product Name">
          <?php
          echo form_error('pro_name', '<span class="er">', '</span>', $errors);
          ?>
        </div>
        <div class="form-group">
          <input name="description" type="text" class="form-control" placeholder="Description">
          <?php
          echo form_error('description', '<span class="er">', '</span>', $errors);
          ?>
        </div>
        <div class="form-group">
          <select name="category" id="" class="form-control">
            <option value="" disabled selected>Category</option>
            <option value="1">Bra Tops</option>
            <option value="2">Dresses & Jumpsuits</option>
            <option value="3">Short Skirts</option>
            <option value="4">Tote Bags</option>
            <option value="5">Satchel Bags</option>
            <option value="6">Womens Backpacks</option>
            <option value="7">Sunglasses</option>
            <option value="8">Hats</option>
            <option value="9">Sale</option>
          </select>
          <?php
          echo form_error('category', '<span class="er">', '</span>', $errors);
          ?>
        </div>
        <div class="form-group">
          <input name="price" type="text" class="form-control" placeholder="Price">
          <?php
          echo form_error('price', '<span class="er">', '</span>', $errors);
          ?>
        </div>
        <div class="form-group">
          <input name="size" type="text" class="form-control" placeholder="Size">
          <?php
          echo form_error('size', '<span class="er">', '</span>', $errors);
          ?>
        </div>
        <div class="form-group">
          <input name="Stock_Quantity" type="number" class="form-control" placeholder="Stock Quantity">
          <?php
          echo form_error('Stock_Quantity', '<span class="er">', '</span>', $errors);
          ?>
        </div>
        <div class="form-group">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
          </div>
        <input type="hidden" name="id" value="<?php echo $productID; ?>">
        <a href="/BnL/admin/products" class="btn btn-primary">Back</a> <button type="submit" class="btn btn-success">Add Product</button>
      </form>
    </div>
  </div>
</body>