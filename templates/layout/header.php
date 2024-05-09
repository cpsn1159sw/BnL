<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($data['pageTitle']) ? $data['pageTitle'] : 'BnL';?></title>
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES;?>/webfonts/all.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES;?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES;?>/css/style.css">
</head>

<header>
<div class="jumbotron-header bg-light">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-solid fa-phone-flip"></i> Hotline: +8412345678</a>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-lg-end">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Trợ giúp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">CSKH VIP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Giới thiệu</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<!-- Menu -->
<nav class="navbar navbar-expand-lg" style="background-color: #F8F7F2;">
    <a class="navbar-brand mx-2"><img class="my-out-img" src="<?php echo _WEB_HOST_TEMPLATES; ?>/images/logo/tittle.png" alt="" style="width: 50px; margin-bottom: -60px; margin-top: -70px;"><img class="my-out-img" src="<?php echo _WEB_HOST_TEMPLATES; ?>/images/logo/BnL_logo.png" alt="" style="width: 50px; margin-bottom: -60px; margin-top: -70px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="collapsibleNavbar">
        <ul class="navbar-nav main mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link main mx-lg-2" href="" id="navbardrop">Nữ</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Áo</a>
                    <a class="dropdown-item" href="#">Quần</a>
                    <a class="dropdown-item" href="#">Đầm & Váy</a>
                    <a class="dropdown-item" href="#">Phụ kiện</a>
                    <a class="dropdown-item" href="#">Nổi bật</a>
                </div>
             </li>

            <li class="nav-item dropdown">
                <a class="nav-link main mx-lg-2" href="" id="navbardrop">Nam</a>
            </li>
            <li class="nav-item">
                <a class="nav-link main mx-lg-2" href="#">Sale</a>
            </li>
            <li class="nav-item">
                <a class="nav-link main mx-lg-2" href="#">New</a>
            </li>
            <li class="nav-item">
                <a class="nav-link main mx-lg-2" href="#">Contact</a>
            </li> 
        </ul>
        <form class="form-inline d-flex ms-auto p-2">
            <input class="form-control" type="text" placeholder="Search">
            <button class="btn btn-success" type="submit">Search</button>
            <a class="nav-link m-auto px-1" href="?module=auth&action=login"><i class="fa-solid fa-user" style="font-size: 30px;"></i></a>
            <a class="nav-link m-auto px-1" href="#"><i class="fa-solid fa-cart-shopping" style="font-size: 30px;"></i></a>
        </form>
    </div>
</nav>
</header>
    