<?php
// Ensure only authorized access
if (!defined('_CODE')) {
    die('Access denied...');
}

// Check login role
if (isLoginA() && (role() == 'Admin' || role() == 'Staff')) {

    // Handle form submission
    if (isPost()) {
        $filterAll = filter();
        $errors = []; // Mảng chứa các lỗi

        // Validate product name
        if (empty($filterAll['pro_name'])) {
            $errors['pro_name'] = '* Please enter the product name.';
        }

        // Validate product description
        if (empty($filterAll['description'])) {
            $errors['description'] = '* Please enter the product description.';
        }

        // Validate product price
        if (empty($filterAll['price'])) {
            $errors['price'] = '* Please enter the product price.';
        } elseif (!is_numeric($filterAll['price'])) {
            $errors['price'] = '* Please enter a valid numeric price for the product.';
        }

        // Validate product discount
        if (!empty($filterAll['discount']) && !is_numeric($filterAll['discount'])) {
            $errors['discount'] = '* Please enter a valid numeric discount value.';
        }

        // Validate product size
        if (empty($filterAll['size'])) {
            $errors['size'] = '* Please enter the product size.';
        }

        // Validate product category
        if (empty($filterAll['category'])) {
            $errors['category'] = '* Please select a product category.';
        }

        // Validate product stock quantity
        if (empty($filterAll['Stock_Quantity'])) {
            $errors['Stock_Quantity'] = '* Please enter the stock quantity.';
        } elseif (!is_numeric($filterAll['Stock_Quantity'])) {
            $errors['Stock_Quantity'] = '* Please enter a valid numeric value for stock quantity.';
        }

        $imagePath = '';

        // Handle file upload
        if (!empty($_FILES['image']['name'])) {
            // Get category name based on category ID
            $cateID = $filterAll['category'];
            $query = oneRow("SELECT * FROM categories WHERE CategoryID = $cateID"); // Assuming you have a function for database query, adjust as needed
            if ($query) {
                $cateName = $query['Name'];
            } else {
                $errors['category'] = '* Invalid category selected.';
            }

            // Ensure image upload directory exists and has write permissions
            $uploadDir = _WEB_PATH_TEMPLATES . '/images/' . sanitizeString($cateName) . '/';
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
                    $errors['image']['dir'] = '* Failed to create directory for image upload.';
                }
            }

            // Full system path of the uploaded file
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

            // Allowed file extensions
            $validExtensions = ['jpg', 'jpeg', 'png'];
            if (in_array($imageFileType, $validExtensions)) {
                // Move uploaded file to storage directory
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $imagePath = '/images/' . sanitizeString($cateName) . '/' . basename($_FILES['image']['name']);
                    $filterAll['image'] = $imagePath;
                } else {
                    $errors['image']['upload'] = '* Unable to upload image. Error: ' . $_FILES['image']['error'];
                    // Log error for debugging
                    error_log('Unable to upload image: ' . $_FILES['image']['error']);
                }
            } else {
                $errors['image']['type'] = '* Only JPG, JPEG, PNG files are allowed.';
            }
        }

        // If no errors, proceed with database insertion
        if (empty($errors)) {
                // Data to insert into database
                $dataInsert = [
                  'Name' => $filterAll['pro_name'],
                  'Description' => $filterAll['description'],
                  'CategoryID' => intval($filterAll['category']),
                  'Price' => floatval($filterAll['price']),
                  'Discount' => floatval($filterAll['discount']),
                  'Size' => $filterAll['size'],
                  'StockQuantity' => intval($filterAll['Stock_Quantity']),
                  'imageURL' => $filterAll['image']
              ];

              // Insertion query assuming PDO usage (adjust as per your database abstraction layer)
              $insertStatus = insert('products', $dataInsert); // Assuming insertP is a function for database insertion
              
                if ($insertStatus) {
                    // Success message and redirect
                    setFlashData('smg', 'Successfully added a new product!');
                    setFlashData('smg_type', 'success');
                    redirect(_WEB_HOST.'/admin/products');
                } else {
                    // Error message if insertion fails
                    setFlashData('smg', 'System encountered an issue. Please try again later!');
                    setFlashData('smg_type', 'danger');
                    redirect(_WEB_HOST.'/admin/products');
                }
        } else {
            // Display error message and redirect back to form
            setFlashData('smg', 'Please check your information again!');
            setFlashData('smg_type', 'danger');
            setFlashData('errors', $errors);
            setFlashData('old', $filterAll);
            redirect(_WEB_HOST.'/products/create');
        }
    }
} else {
    // Redirect if unauthorized access
    setFlashData('smg', 'You are not authorized to access this page and have been logged out!');
    setFlashData('smg_type', 'danger');
    redirect(_WEB_HOST.'/admin/logout');
}

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BnL - Add Product</title>
    <!-- Path to CSS files -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/themefisher-font/style.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/animate/animate.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/slick/slick.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/slick/slick-theme.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/css/style.css">
</head>

<body id="body">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="panel-title">Add Product</h2>
        </div>
        <div class="panel-body">
            <?php
            if (!empty($smg)) {
              getSmg($smg, $smg_type);
            }
            ?>
            <!-- Product form -->
            <form class="text-left clearfix" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input name="pro_name" type="text" class="form-control" placeholder="Product Name"
                        value="<?php echo (old_data('pro_name', $old)) ?>">
                    <?php
                    // Display error message if exists
                    if (!empty($errors['pro_name'])) {
                        echo '<span class="er">' . htmlspecialchars($errors['pro_name']) . '</span>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <input name="description" type="text" class="form-control" placeholder="Description"
                        value="<?php echo (old_data('description', $old)) ?>">
                    <?php
                    // Display error message if exists
                    if (!empty($errors['description'])) {
                        echo '<span class="er">' . htmlspecialchars($errors['description']) . '</span>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <select name="category" id="category" class="form-control">
                        <option value="" disabled selected>Category</option>
                        <option value="1"
                            <?php echo (old_data('category', $old) == "1") ? 'selected' : ''; ?>>Bra Tops</option>
                        <option value="2"
                            <?php echo (old_data('category', $old) == "2") ? 'selected' : ''; ?>>Dresses & Jumpsuits</option>
                        <option value="3"
                            <?php echo (old_data('category', $old) == "3") ? 'selected' : ''; ?>>Short Skirts</option>
                        <option value="4"
                            <?php echo (old_data('category', $old) == "4") ? 'selected' : ''; ?>>Tote Bags</option>
                        <option value="5"
                            <?php echo (old_data('category', $old) == "5") ? 'selected' : ''; ?>>Satchel Bags</option>
                        <option value="6"
                            <?php echo (old_data('category', $old) == "6") ? 'selected' : ''; ?>>Womens Backpacks</option>
                        <option value="7"
                            <?php echo (old_data('category', $old) == "7") ? 'selected' : ''; ?>>Sunglasses</option>
                        <option value="8"
                            <?php echo (old_data('category', $old) == "8") ? 'selected' : ''; ?>>Hats</option>
                        <option value="9"
                            <?php echo (old_data('category', $old) == "9") ? 'selected' : ''; ?>>Sale</option>
                    </select>
                    <?php
                    // Display error message if exists
                    if (!empty($errors['category'])) {
                        echo '<span class="er">' . htmlspecialchars($errors['category']) . '</span>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <input name="price" type="text" class="form-control" placeholder="Price"
                        value="<?php echo (old_data('price', $old)) ?>">
                    <?php
                    // Display error message if exists
                    if (!empty($errors['price'])) {
                        echo '<span class="er">' . htmlspecialchars($errors['price']) . '</span>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <input name="discount" type="text" class="form-control" placeholder="Discount"
                        value="<?php echo (old_data('discount', $old)) ?>">
                    <?php
                    // Display error message if exists
                    if (!empty($errors['discount'])) {
                        echo '<span class="er">' . htmlspecialchars($errors['discount']) . '</span>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <input name="size" type="text" class="form-control" placeholder="Size"
                        value="<?php echo (old_data('size', $old)) ?>">
                    <?php
                    // Display error message if exists
                    if (!empty($errors['size'])) {
                        echo '<span class="er">' . htmlspecialchars($errors['size']) . '</span>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <input name="Stock_Quantity" type="number" class="form-control" placeholder="Stock Quantity"
                        value="<?php echo (old_data('Stock_Quantity', $old)) ?>">
                    <?php
                    // Display error message if exists
                    if (!empty($errors['Stock_Quantity'])) {
                        echo '<span class="er">' . htmlspecialchars($errors['Stock_Quantity']) . '</span>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <?php
                    // Display error message if exists
                    if (!empty($errors['image'])) {
                        if (!empty($errors['image']['upload'])) {
                            echo '<span class="er">' . htmlspecialchars($errors['image']['upload']) . '</span>';
                        }
                        if (!empty($errors['image']['type'])) {
                            echo '<span class="er">' . htmlspecialchars($errors['image']['type']) . '</span>';
                        }
                        if (!empty($errors['image']['dir'])) {
                            echo '<span class="er">' . htmlspecialchars($errors['image']['dir']) . '</span>';
                        }
                    }
                    ?>
                </div>
                <a href="<?php echo _WEB_HOST ?>/admin/products" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-success">Add Product</button>
            </form>
        </div>
    </div>
    <!-- Path to JS files if needed -->
    <script src="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/jquery.min.js"></script>
    <script src="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/slick/slick.min.js"></script>
    <script src="<?php echo _WEB_HOST_TEMPLATES ?>/js/script.js"></script>
</body>

</html>

