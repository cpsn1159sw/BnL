<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo !empty($data['pageTitle']) ? $data['pageTitle'] : 'BnL - Home'; ?></title>
	<meta charset="utf-8">
	<!-- Mobile Specific Metas
  ================================================== -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
	<meta name="author" content="BnL">

	<!-- Favicon -->
	<link rel="" type="" href="">

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

	<style>
		.search-dropdown {
			padding: 20px;
			background-color: #f7f7f7;
			border: 1px solid #ddd;
			width: 300px;
		}

		.search-dropdown input[type="text"] {
			width: 100%;
			padding: 10px;
			margin-bottom: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
		}

		.search-dropdown button[type="submit"] {
			display: none;
		}

		.search-result-item {
			display: flex;
			align-items: center;
			padding: 10px 0;
			border-bottom: 1px solid #ddd;
		}

		.search-result-item img {
			width: 50px;
			height: auto;
			margin-right: 10px;
		}

		.search-result-item h4 {
			margin: 0;
			font-size: 14px;
		}

		.search-result-item p {
			margin: 0;
			font-size: 12px;
			color: #888;
		}
	</style>
</head>

<header id="body">
	<!-- Start Top Header Bar -->
	<section class="top-header">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-xs-12 col-sm-4">
					<div class="contact-number">
						<i class="tf-ion-ios-telephone"></i>
						<span>0129- 12323-123123</span>
					</div>
				</div>
				<div class="col-md-4 col-xs-12 col-sm-4">
					<!-- Site Logo -->
					<div class="logo text-center">
						<a href="/BnL/Public/home">
							<img src="<?php echo _WEB_HOST_TEMPLATES ?>/images/logo/titleBnL.png" style="height: 20vh;" alt="">
						</a>
					</div>
				</div>
				<div class="col-md-4 col-xs-12 col-sm-4">
					<!-- Cart -->
					<ul class="top-menu text-right list-inline">
						<li class="dropdown cart-nav dropdown-slide">
							<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="tf-ion-android-cart"></i>Cart</a>
							<div class="dropdown-menu cart-dropdown">

								<!-- Cart Item -->

								<div class="cart-summary">
									<span></span>
									<span class="total-price"></span>
								</div>
								<ul class="text-center cart-buttons">
									<li><a href="/BnL/public/cart" class="btn btn-small">View Cart</a></li>
									<li><a href="/BnL/user/login" class="btn btn-small btn-solid-border">Checkout</a></li>
								</ul>
							</div>

						</li><!-- / Cart -->

						<!-- Search -->
						<li class="dropdown search dropdown-slide">
							<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="tf-ion-ios-search-strong"></i> Search</a>
							<ul class="dropdown-menu search-dropdown">
								<li>
									<form method="post">
										<p>
											<input type="text" name="search" class="form-control" placeholder="Search..." required>
											<button type="submit" name="btn"><i class="tf-ion-ios-search-strong"></i></button>
										</p>
									</form>
									<?php
									// Khởi tạo biến query là một mảng rỗng ban đầu để tránh lỗi undefined variable
									$query = [];

									// Kiểm tra nếu form đã được gửi đi và nút tìm kiếm được nhấn
									if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn'])) {
										$noidung = $_POST['search'];

										// Nếu có từ khóa tìm kiếm, thực hiện truy vấn để tìm sản phẩm
										if (!empty($noidung)) {
											$searchQuery = "SELECT * FROM products WHERE Name LIKE '%$noidung%'";
											$query = getRows($searchQuery);

											// Kiểm tra kết quả của truy vấn tìm kiếm
											if (!empty($query)) {
												foreach ($query as $item) :
									?>
													<div class="search-result-item">
														<a class="pull-left" href="product-single&ProductID=<?php echo $item["ProductID"]; ?>">
															<img src="<?php echo htmlspecialchars(_WEB_HOST_TEMPLATES . $item['imageURL'], ENT_QUOTES, 'UTF-8'); ?>" alt="product-img" />
														</a>
														<div class="media-body">
															<h4><?php echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8'); ?></h4>
															<p class="price">Price: $<?php echo htmlspecialchars($item['Price'], ENT_QUOTES, 'UTF-8'); ?></p>
														</div>
													</div>
											<?php
												endforeach;
											} else {
												// Nếu không có kết quả tìm kiếm
												echo '<p>No products found.</p>';
											}
										}
									} else {
										// Trường hợp mặc định khi chưa thực hiện tìm kiếm
										$defaultQuery = "SELECT p.ProductID AS ProductID, p.Name AS Name, p.Price AS Price, p.imageURL AS imageURL, SUM(od.Quantity) AS TotalQuantity
                                FROM OrderDetails od
                                INNER JOIN products p ON p.ProductID = od.ProductID
                                INNER JOIN Orders o ON o.OrderID = od.OrderID
                                WHERE o.Status = 'Delivered'
                                GROUP BY p.ProductID, p.Name, p.Price, p.imageURL
                                ORDER BY TotalQuantity DESC
                                LIMIT 5";
										$query = getRows($defaultQuery);

										// Hiển thị kết quả mặc định
										foreach ($query as $item) :
											?>
											<div class="search-result-item">
												<a class="pull-left" href="product-single&ProductID=<?php echo $item["ProductID"]; ?>">
													<img src="<?php echo htmlspecialchars(_WEB_HOST_TEMPLATES . $item['imageURL'], ENT_QUOTES, 'UTF-8'); ?>" alt="product-img" />
												</a>
												<div class="media-body">
													<h4><?php echo htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8'); ?></h4>
													<p class="price">Price: $<?php echo htmlspecialchars($item['Price'], ENT_QUOTES, 'UTF-8'); ?></p>
												</div>
											</div>
									<?php
										endforeach;
									}
									?>
								</li>
							</ul>
						</li>

					</ul>
					</li><!-- / Search -->
					</ul><!-- / .nav .navbar-nav .navbar-right -->
				</div>
			</div>
		</div>
	</section><!-- End Top Header Bar -->

	<!-- Main Menu Section -->
	<section class="menu">
		<nav class="navbar navigation">
			<div class="container">
				<div class="navbar-header">
					<h2 class="menu-title">Main Menu</h2>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

				</div><!-- / .navbar-header -->

				<!-- Navbar Links -->
				<div id="navbar" class="navbar-collapse collapse text-center">
					<ul class="nav navbar-nav">

						<!-- Home -->
						<li class="dropdown ">
							<a href="/BnL/Public/home">Home</a>
						</li><!-- / Home -->

						<!-- Pages -->
						<li class="dropdown full-width dropdown-slide">
							<a href="/BnL/public/shop" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Shop <span class="tf-ion-ios-arrow-down"></span></a>
							<div class="dropdown-menu">
								<div class="row">

									<!-- Women -->
									<div class="col-sm-3 col-xs-12">
										<ul>
											<li class=" ">Women</li>
											<li role=" " class="divider"></li>
											<li><a href="/BnL/public/Bra-tops">Bra Tops</a></li>
											<li><a href="/BnL/public/D-and-J">Dresses & Jumpsuits</a></li>
											<li><a href="/BnL/public/Short-skirts">Short Skirts</a></li>
										</ul>
									</div>

									<!-- Bags -->
									<div class="col-sm-3 col-xs-12">
										<ul>
											<li class=" ">Bags</li>
											<li role=" " class="divider"></li>
											<li><a href="/BnL/public/Tote-bags">Tote Bags</a></li>
											<li><a href="/BnL/public/Satchel-bags">Satchel Bags</a></li>
											<li><a href="/BnL/public/Women-Backpacks">Women's Backpacks</a></li>
										</ul>
									</div>

									<!-- Accessories -->
									<div class="col-sm-3 col-xs-12">
										<ul>
											<li class=" ">Accessories</li>
											<li role=" " class="divider"></li>
											<li><a href="/BnL/public/Sunglasses">Sunglasses</a></li>
											<li><a href="/BnL/public/Hats">Hats</a></li>
										</ul>
									</div>

									<!-- Mega Menu -->
									<div class="col-sm-3 col-xs-12">
										<a href=" ">
											<img class="img-responsive" src="<?php echo _WEB_HOST_TEMPLATES ?>/images/logo/header.jpg" alt="menu image" />
										</a>
									</div>
								</div><!-- / .row -->
							</div><!-- / .dropdown-menu -->
						</li><!-- / Pages -->

						<!-- Sale -->
						<li class="dropdown ">
							<a href="/BnL/public/sale">Sale</a>
						</li><!-- / Sale -->
						<!-- Login -->
						<li class="dropdown dropdown-slide">
							<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Utility <span class="tf-ion-ios-arrow-down"></span></a>
							<ul class="dropdown-menu">
								<li><a href="/BnL/user/login">Login Page</a></li>
								<li><a href="/BnL/user/signup">Signup Page</a></li>
								<li><a href="/BnL/user/forgot">Forget Password</a></li>
							</ul>
						</li><!-- / Login -->
						<!-- About -->
						<li class="dropdown ">
							<a href="/BnL/public/about">About</a>
						</li><!-- / About -->

						<!-- Contact -->
						<li class="dropdown ">
							<a href="/BnL/public/contact">Contact</a>
						</li><!-- / Contact -->

						<!-- Shop -->
					</ul><!-- / .nav .navbar-nav -->

				</div>
				<!--/.navbar-collapse -->
			</div><!-- / .container -->
		</nav>
	</section>
</header>