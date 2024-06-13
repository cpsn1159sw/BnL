<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
	die('Access denied...');
}

$data = [
	'pageTitle' => ''
];

if (!isLogin()) {
	layouts('header', $data);
} else {
	layouts('header_login', $data);
}

// Kết nối đến cơ sở dữ liệu
$connection = mysqli_connect("localhost", "root", "", "db_shop");

if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}

// Kiểm tra xem có ID sản phẩm được truyền qua URL không
if (isset($_GET['ProductID'])) {
	$product_id = $_GET['ProductID'];

	// Sử dụng prepared statement để tránh SQL Injection
	$query = "SELECT * FROM products WHERE ProductID = ?";
	$stmt = mysqli_prepare($connection, $query);

	// Bind parameter
	mysqli_stmt_bind_param($stmt, "i", $product_id);

	// Thực thi truy vấn
	mysqli_stmt_execute($stmt);

	// Lấy kết quả
	$result = mysqli_stmt_get_result($stmt);

	// Kiểm tra xem có dữ liệu trả về không
	if (mysqli_num_rows($result) > 0) {
		$product = mysqli_fetch_assoc($result);
		// Hiển thị thông tin chi tiết sản phẩm

	} else {
		echo "Product not found!";
	}
} else {
	echo "Product ID is missing!";
}

// Đóng kết nối
mysqli_close($connection);
?>

<section class="single-product">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<ol class="breadcrumb">
					<li><a href="/BnL/public/home">Home</a></li>
					<li><a href="/BnL/public/shop">Shop</a></li>
					<li class="active">Single Product</li>
				</ol>
			</div>
		</div>
		<div class="row mt-20">
			<div class="col-md-5">
				<div class="single-product-slider">
					<div id='carousel-custom' class='carousel slide' data-ride='carousel'>
						<div class='carousel-outer'>
							<!-- me art lab slider -->
							<div class='carousel-inner '>
								<div class='item active'>
									<img src='<?php echo _WEB_HOST_TEMPLATES . $product['image-url']; ?>' alt='' data-zoom-image="images/shop/single-products/product-1.jpg" />
								</div>
							</div>
							<!-- sag sol -->
							<a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
								<i class="tf-ion-ios-arrow-left"></i>
							</a>
							<a class='right carousel-control' href='#carousel-custom' data-slide='next'>
								<i class="tf-ion-ios-arrow-right"></i>
							</a>
						</div>

						<!-- thumb -->
						<ol class='carousel-indicators mCustomScrollbar meartlab'>
							<li data-target='#carousel-custom' data-slide-to='0' class='active'>
								<img src='<?php echo _WEB_HOST_TEMPLATES . $product['image-url']; ?>' alt='' />
							</li>
						</ol>
					</div>
				</div>
			</div>
			<div class="col-md-7">
				<div class="single-product-details">
					<h2><?php echo $product['Name']; ?></h2>
					<p class="product-price">$<?php echo $product['Price']; ?></p>
					<p class="product-description mt-20"><?php echo $product['Description']; ?></p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt, velit, sunt temporibus, nulla accusamus similique sapiente tempora, at atque cumque assumenda minus asperiores est esse sequi dolore magnam. Debitis, explicabo.</p>
					<div class="product-size">
						<span>Size:</span>
						<select class="form-control">
							<option>S</option>
							<option>M</option>
							<option>L</option>
							<option>XL</option>
						</select>
					</div>
					<div class="product-quantity">
						<span>Quantity:</span>
						<div class="product-quantity-slider">
							<input id="product-quantity" type="text" value="0" name="product-quantity">
						</div>
					</div>
					<?php
					if (!isLogin()) {
					?>
						<a href="/BnL/public/add-to-cart&id=<?php echo $product["ProductID"]; ?>"><i class="btn btn-main mt-20" aria-hidden="true">Add To Cart</i></a>
					<?php
					} else {
					?>
						<a href="/BnL/public/add-to-cart&id=<?php echo $product["ProductID"]; ?>" target="_blank"><i class="tbtn btn-main mt-20" aria-hidden="true">Add To Cart</i></a>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="tabCommon mt-20">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#details" aria-expanded="true">Details</a></li>
					</ul>
					<div class="tab-content patternbg">
						<div id="details" class="tab-pane fade active in">
							<h4>Product Description</h4>
							<p><?php echo $product['Description']; ?></p>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis delectus quidem repudiandae veniam distinctio repellendus magni pariatur molestiae asperiores animi, eos quod iusto hic doloremque iste a, nisi iure at unde molestias enim fugit, nulla voluptatibus. Deserunt voluptate tempora aut illum harum, deleniti laborum animi neque, praesentium explicabo, debitis ipsa?</p>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php layouts('footer') ?>