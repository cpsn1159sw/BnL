<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
	die('Access denied...');
}
$data = [
	'pageTitle' => 'Sale'
];

if (!isLogin()) {
	layouts('header', $data);
} else {
	layouts('header_login', $data);
}

?>
<!-- Page Header -->

<body class="body">
	<section class="page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="content">
						<h1 class="page-name">Sale</h1>
						<ol class="breadcrumb">
							<li><a href="/BnL/Public/home">Home</a></li>
							<li><a href="/BnL/Public/shop">Shop</a></li>
							<li class="active">Sale</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="products section">
	<div class="container">
			<div class="row">
				<?php
				$salelist = getRows("SELECT * FROM products WHERE categoryid = 9");
				if (!empty($salelist)) :
					foreach ($salelist as $index => $item) :
				?>
						<div class="col-md-4">
							<div class="product-item">
								<div class="product-thumb">
								<span class="bage">Sale</span>
									<img class="img-responsive" src="<?php echo _WEB_HOST_TEMPLATES.$item['image-url']; ?>" alt="product-img" />
									<div class="preview-meta">
										<ul>
											<li>
												<span data-toggle="modal" data-target="#product-modal-<?php echo $index; ?>">
													<i class="tf-ion-ios-search-strong"></i>
												</span>
											</li>
											<li>
												<a href="/BnL/public/add-to-cart&id=<?php echo $item["ProductID"];?>"><i class="tf-ion-android-cart"></i></a>
											</li>
										</ul>
									</div>
								</div>
								<div class="product-content">
									<h4><a href="/BnL/public/product-single&ProductID=<?php echo $item['ProductID']; ?>"><?php echo $item['Name']; ?></a></h4>
									<p class="price"><?php echo $item['Price']; ?></p>
								</div>
							</div>

							<!-- Modal -->
							<div class="modal product-modal fade" id="product-modal-<?php echo $index; ?>">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i class="tf-ion-close"></i>
								</button>
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-body">
											<div class="row">
												<div class="col-md-8 col-sm-6 col-xs-12">
													<div class="modal-image">
														<img class="img-responsive" src="<?php echo _WEB_HOST_TEMPLATES . $item['image-url']; ?>" alt="product-img" />
													</div>
												</div>
												<div class="col-md-4 col-sm-6 col-xs-12">
													<div class="product-short-details">
														<h2 class="product-title"><?php echo $item['Name']; ?></h2>
														<p class="product-price"><?php echo $item['Price']; ?></p>
														<p class="product-short-description">
															<?php echo $item['Description']; ?>
														</p>
														<a href="/BnL/public/add-to-cart&id=<?php echo $item["ProductID"];?>" class="btn btn-main">Add To Cart</a>
														<a href="/BnL/public/product-single&ProductID=<?php echo $item['ProductID']; ?>" class="btn btn-transparent">View Product Details</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div><!-- /.modal -->
						</div>
				<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</section>

</body>
<?php layouts('footer'); ?>