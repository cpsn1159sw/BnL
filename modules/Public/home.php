<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}

$data = [
    'pageTitle' => 'BnL - Home'
];

if (!isLogin()) {
    layouts('header', $data);
} else {
    layouts('header_login', $data);
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>

<body id="body">
    <div class="hero-slider">
        <div class="slider-item th-fullpage hero-area" style="background-image: url(<?php echo _WEB_HOST_TEMPLATES ?>/images/home/1.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 text-center">
                        <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                        <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">Elegance and sophistication <br>of women.</h1>
                        <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn" href="/BnL/Public/shop">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-item th-fullpage hero-area" style="background-image: url(<?php echo _WEB_HOST_TEMPLATES ?>/images/home/2.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 text-left">
                        <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                        <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature <br> is hidden in details.</h1>
                        <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn" href="/BnL/Public/shop">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-item th-fullpage hero-area" style="background-image: url(<?php echo _WEB_HOST_TEMPLATES ?>/images/home/3.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 text-right">
                        <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                        <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The allure of a woman <br> is expressed through <br>every delicate feature.</h1>
                        <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn" href="/BnL/Public/shop">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Category -->
    <section class="product-category section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title text-center">
                        <h2>Product Category</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category-box">
                        <a href="D-and-J">
                            <img src="<?php echo _WEB_HOST_TEMPLATES ?>/images/Product-category/Pro-category-1.jpg" alt="" />
                            <div class="content">
                                <h3>Dresses</h3>
                                <p>Shop New Season Clothing</p>
                            </div>
                        </a>
                    </div>
                    <div class="category-box">
                        <a href="Satchel-bag">
                            <img src="<?php echo _WEB_HOST_TEMPLATES ?>/images/Product-category/Pro-category-2.jpg" alt="" />
                            <div class="content">
                                <h3>Smart Casuals</h3>
                                <p>Get Wide Range Selection</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category-box category-box-2">
                        <a href="Sunglasses">
                            <img src="<?php echo _WEB_HOST_TEMPLATES ?>/images/Product-category/Pro-category-3.jpg" alt="" />
                            <div class="content">
                                <h3>Sunglasses</h3>
                                <p>Special Design Comes First</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trendy Products -->
    <section class="products section bg-gray">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2>Trendy Products</h2>
                </div>
            </div>
            <div class="row">
                <?php
                if (!empty($smg)) {
                    getSmg($smg, $smg_type);
                }
                $trendylist = getRows("SELECT * FROM products");
                if (!empty($trendylist)) :
                    foreach ($trendylist as $index => $item) :
                ?>
                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img class="img-responsive" src="<?php echo _WEB_HOST_TEMPLATES . $item['image-url']; ?>" alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <span data-toggle="modal" data-target="#trendy-modal-<?php echo $index; ?>">
                                                    <i class="tf-ion-ios-search-strong"></i>
                                                </span>
                                            </li>
                                            <li>
                                                <?php
                                                if (!isLogin()) {
                                                ?>
                                                    <a href="/BnL/public/add-to-cart&id=<?php echo $item["ProductID"]; ?>"><i class="tf-ion-android-cart" aria-hidden="true"></i></a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a href="/BnL/public/add-to-cart&id=<?php echo $item["ProductID"]; ?>" target="_blank"><i class="tf-ion-android-cart" aria-hidden="true"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single&id=<?php echo $item["ProductID"]; ?>"><?php echo $item['Name']; ?></a></h4>
                                    <p class="price"><?php echo $item['Price']; ?></p>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal product-modal fade" id="trendy-modal-<?php echo $index; ?>">
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
                                                        <?php
                                                        if (!isLogin()) {
                                                        ?>
                                                            <a href="/BnL/public/add-to-cart&id=<?php echo $item["ProductID"]; ?>" class="btn btn-main">Add To Cart</a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="/BnL/public/add-to-cart&id=<?php echo $item["ProductID"]; ?>" target="_blank" class="btn btn-main">Add To Cart</a>
                                                        <?php
                                                        }
                                                        ?>
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

    <!-- Sale Products-->
    <section class="products section bg-gray">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2>Sale Products</h2>
                </div>
            </div>
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
                                    <img class="img-responsive" src="<?php echo _WEB_HOST_TEMPLATES . $item['image-url']; ?>" alt="product-img" />
                                    <div class="preview-meta">
                                        <ul>
                                            <li>
                                                <span data-toggle="modal" data-target="#sale-modal-<?php echo $index; ?>">
                                                    <i class="tf-ion-ios-search-strong"></i>
                                                </span>
                                            </li>
                                            <li>
                                            <?php
                                                if (!isLogin()) {
                                                ?>
                                                    <a href="/BnL/public/add-to-cart&id=<?php echo $item["ProductID"]; ?>"><i class="tf-ion-android-cart" aria-hidden="true"></i></a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a href="/BnL/public/add-to-cart&id=<?php echo $item["ProductID"]; ?>" target="_blank"><i class="tf-ion-android-cart" aria-hidden="true"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4><a href="product-single.html"><?php echo $item['Name']; ?></a></h4>
                                    <p class="price"><?php echo $item['Price']; ?></p>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal product-modal fade" id="sale-modal-<?php echo $index; ?>">
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
                                                        <?php
                                                        if (!isLogin()) {
                                                        ?>
                                                            <a href="/BnL/public/add-to-cart&id=<?php echo $item["ProductID"]; ?>" class="btn btn-main">Add To Cart</a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="/BnL/public/add-to-cart&id=<?php echo $item["ProductID"]; ?>" target="_blank" class="btn btn-main">Add To Cart</a>
                                                        <?php
                                                        }
                                                        ?>
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
<script>
    const imgposition = document.querySelectorAll(".slider-item.th-fullpage.hero-area")
    const imgcontainer = document.querySelector('.slider-item.th-fullpage.hero-area')
    let index = 0
    imgposition.forEach(function(imagge, index) {
        image.style.left = index * 100 + "%"
    })

    function imgslide() {
        index++;

        function slider(index) {
            imgcontainer.style.left = "-" + index * 100 + "%"
        }
    }
    setInterval(imgslide, 5000)
</script>

</html>