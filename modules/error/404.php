<!-- Quên mật khẩu tài khoản -->
<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }
$data = [
    'pageTitle' => 'Not Found'
];
layouts('header', $data);
?>
<link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/css/style.css">
<body id="body">
	<section class="page-404">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a href="?">
						<img src="<?php echo _WEB_HOST_TEMPLATES; ?>/images/logo/title.png" alt="site logo" style="width: 20%;">
					</a>
					<h1>404</h1>
					<h2>Page Not Found</h2>
					<a href="?" class="btn btn-main"><i class="tf-ion-android-arrow-back"></i> Go Home</a>
				</div>
			</div>
		</div>
	</section>
</body>
