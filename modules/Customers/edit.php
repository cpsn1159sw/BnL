<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}

// Kiểm tra vai trò đăng nhập
if (isLoginA() && (role() == 'Admin' || role() == 'Staff')) {

    $filterAll = filter();
    if(!empty($filterAll['id'])) {
        $customerID = $filterAll['id'];

        $info = oneRow("SELECT * FROM customer WHERE CustomerID = '$customerID'");
        if(!empty($info)) {
            setFlashData('info', $info);
        } else {
            redirect('/BnL/admin/customers');
        }
    }

    if (isPost()) {
        $filterAll = filter();
        $errors = []; // Mảng chứa các lỗi

        // Validate fullname
        if (empty($filterAll['fullname'])) {
            $errors['fullname']['required'] = '*Please enter your full name.';
        } else {
            if (strlen($filterAll['fullname']) < 5) {
                $errors['fullname']['min'] = '*Full name must be at least 5 characters.';
            }
        }

        // Validate email
        if (empty($filterAll['email'])) {
            $errors['email']['required'] = '*Please enter your email.';
        } else {
            $email = $filterAll['email'];
            $sql = "SELECT CustomerID FROM customer WHERE Email = '$email' AND CustomerID <> $customerID";
            if (countRows($sql) > 0) {
                $errors['email']['unique'] = '*Email already exists.';
            }
        }

        // Validate phone number
        if (empty($filterAll['phone'])) {
            $errors['phone']['required'] = '*Please enter your phone number.';
        } else {
            if (!isPhone($filterAll['phone'])) {
                $errors['phone']['isPhone'] = '*The phone number is invalid.';
            } else {
                $phone = $filterAll['phone'];
                $query = "SELECT CustomerID FROM customer WHERE Phone = '$phone' AND CustomerID <> $customerID";
                if (countRows($query) > 0) {
                    $errors['phone']['unique'] = '*This phone already exists.';
                }
            }
        }

        // Validate status
        if (empty($filterAll['status'])) {
            $errors['status']['required'] = '*Please choose your status.';
        }

        // Validate address
        if (empty($filterAll['address'])) {
            $errors['address']['required'] = '*Please enter your address.';
        }

        if (empty($errors)) {
            $dataUpdate = [
                'FullName' => $filterAll['fullname'],
                'Address' => $filterAll['address'],
                'Email' => $filterAll['email'],
                'Phone' => $filterAll['phone'],
                'Status' => $filterAll['status']
            ];

            if(!empty($filterAll['password'])) {
                $dataUpdate['password'] = password_hash($filterAll['password'], PASSWORD_DEFAULT);
            }

            $condition = "CustomerID = $customerID";
            $insertStatus = update('customer', $dataUpdate, $condition); // NHỚ ĐỔI LẠI TÊN BẲNG customer SAU NÀY 
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
        redirect('/BnL/customers/edit&id='.$customerID);
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

<title>BnL - Customer Edit</title>

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
            <h2 class="panel-title">Edit customer information</h2>
        </div>
        <div class="panel-body">
            <?php
            if (!empty($smg)) {
                getSmg($smg, $smg_type);
            }
            ?>
            <form class="text-left clearfix" action="" method="post">
                <div class="form-group">
                    <input name="fullname" type="text" class="form-control" placeholder="Họ và tên" value="<?php echo old_data('FullName', $old) ?>">
                    <?php
                    // echo (!empty($errors['fullname'])) ? '<span class="er">'.reset($errors['fullname']).'</span>' : null;
                    echo form_error('fullname', '<span class="er">', '</span>', $errors);
                    ?>
                </div>
                <div class="form-group">
                    <input name="address" type="text" class="form-control" placeholder="Address" value="<?php echo old_data('Address', $old) ?>">
                    <?php
                    echo form_error('address', '<span class="er">', '</span>', $errors);
                    ?>
                </div>
                <div class="form-group">
                    <input name="email" type="email" class="form-control" placeholder="Email" value="<?php echo old_data('Email', $old) ?>">
                    <?php
                    echo form_error('email', '<span class="er">', '</span>', $errors);
                    ?>
                </div>
                <div class="form-group">
                    <input name="phone" type="text" class="form-control" placeholder="Phone Number" value="<?php echo old_data('Phone', $old) ?>">
                    <?php
                    echo form_error('phone', '<span class="er">', '</span>', $errors);
                    ?>
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Password (Do not enter if unchanged)">
                    <?php
                    echo form_error('password', '<span class="er">', '</span>', $errors);
                    ?>
                </div>
                <div class="form-group">
                    <select name="status" id="" class="form-control">
                        <option value="" disabled selected>Status</option>
                        <option value="1" <?php echo (old_data('Status', $old) == "1") ? 'selected' : false; ?>>Active</option>
                        <option value="NULL" <?php echo (old_data('Status', $old) == "NULL") ? 'selected' : false; ?>>None Active</option>
                    </select>
                    <?php
                    echo form_error('status', '<span class="er">', '</span>', $errors);
                    ?>
                </div>
                <input type="hidden" name="id" value="<?php echo $customerID; ?>">
                <a href="/BnL/admin/customers" class="btn btn-primary">Back</a> <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</body>