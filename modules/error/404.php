<!-- Quên mật khẩu tài khoản -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }
?>
  <title>BnL - Not Found</title>
  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/themefisher-font/style.css">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/bootstrap/css/bootstrap.min.css">
  
  <!-- Animate css -->
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/animate/animate.css">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/slick/slick.css">
  <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/slick/slick-theme.css">
  
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/css/style.css">

<body id="body">
	<section class="page-404">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a href="<?php echo _WEB_HOST?>/public/home"">
						<img src="<?php echo _WEB_HOST_TEMPLATES; ?>/images/logo/titleBnL.png" alt="site logo" style="width: 20%;">
					</a>
					<h1>404</h1>
					<h2>Page Not Found</h2>
					<a href="<?php echo _WEB_HOST?>/public/home" class="btn btn-main"><i class="tf-ion-android-arrow-back"></i> Go Home</a>
				</div>
			</div>
		</div>
	</section>
</body>
