<?php 
// Chặn truy cập hợp lệ
if(!defined('_CODE')) {
    die('Access denied...');
}
$data = [
    'pageTitle' => 'Contact'
];

if(!isLogin()) {
	layouts('header', $data);
} else {
	layouts('header_login', $data);
}

?>
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Contact Us</h1>
					<ol class="breadcrumb">
						<li><a href="<?php echo _WEB_HOST?>/public/home">Home</a></li>
						<li class="active">Contact</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="page-wrapper">
	<div class="contact-section">
		<div class="container">
			<div class="row">
				<!-- Contact Form -->
				<div class="col-lg-6">
					<div class="post">
						<div class="post-media post-media-video">
							<iframe width="560" height="315" src="https://www.youtube.com/embed/Jh65uUdLCZM" frameborder="0" allowfullscreen></iframe>
						</div>
						<ul>
							<li>
								<i class="tf-ion-ios-calendar"></i> 16, Jun 2024
							</li>
							<li>
								<i class="tf-ion-android-person"></i> POSTED BY ADMIN
							</li>
							<li>
								<a><i class="tf-ion-ios-pricetags"></i> LIFESTYLE</a>,<a> TRAVEL</a>, <a>FASHION</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- Contact Details -->
				<div class="contact-details col-md-6">
					<div class="google-map">
						<div id="map" style="width: 100%; height: 400px;"></div>
					</div>
					<ul class="contact-short-info">
						<li>
							<i class="tf-ion-ios-home"></i>
							<span>11 Nguyễn Đình Chiểu, Đa Kao, Quận 1, Thành phố Hồ Chí Minh, Việt Nam</span>
						</li>
						<li>
							<i class="tf-ion-android-phone-portrait"></i>
							<span>Phone: +84-129-12323-123123</span>
						</li>
						<li>
							<i class="tf-ion-android-mail"></i>
							<span>Email: cskhbandl@gmail.com</span>
						</li>
					</ul>
					<!-- Footer Social Links -->
					<div class="social-icon">
						<ul>
							<li><a class="fb-icon" href="https://www.facebook.com"><i class="tf-ion-social-facebook"></i></a></li>
							<li><a href="https://www.twitter.com"><i class="tf-ion-social-twitter"></i></a></li>
							<li><a href="https://www.pinterest.com/"><i class="tf-ion-social-pinterest-outline"></i></a></li>
						</ul>
					</div>
					<!--/. End Footer Social Links -->
				</div>
				<!-- / End Contact Details -->
			</div> <!-- end row -->
		</div> <!-- end container -->
	</div>
</section>

<?php layouts('footer'); ?>