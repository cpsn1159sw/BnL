<?php
// Chặn truy cập hợp lệ
if (!defined('_CODE')) {
    die('Access denied...');
}
$data = [
    'pageTitle' => 'BnL - About'
];

if (!isLogin()) {
    layouts('header', $data);
} else {
    layouts('header_login', $data);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="author" content="BnL">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/themefisher-font/style.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/animate/animate.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/slick/slick.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/plugins/slick/slick-theme.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATES ?>/css/style.css">
    <style>

        .main {
            padding: 40px;
            background: #fff;
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 10px 8px 8px 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2,
        h3 {
            color: #333;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2.5em;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        h2 {
            font-size: 1.75em;
            color: #2c3e50;
        }

        p {
            color: #555;
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }


        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .cta {
            display: inline-block;
            padding: 10px 20px;
            background: #3498db;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .cta:hover {
            background: #2980b9;
        }
    </style>
</head>

<body id="body">
    <div class="container">
        <div class="main">
            <h1>Introduction</h1>
            <h2> Welcome to BnL.</h2>
            <p> At BnL, we believe that fashion is more than just clothes, it is a form of self-expression, a way to tell your story without having to say a word. Our mission is to provide you with high-quality, fashionable clothing that makes you feel confident and unique.</p>

            <h2>Our story</h2>
            <p>BnL is a store with a big dream: bringing the latest fashion trends to everyone. Over the years, we have grown into a beloved brand, known for our commitment to quality, innovation and outstanding customer service.</p>

            <h2>Our developers</h2>
            <p>We offer a wide variety of apparel for every occasion, whether you're looking for casual locations, real estate maps, or maps for special events. Our collection includes:</p>
            <ul>
                <li><strong>Women's Fashion</strong>: BRA TOPS, DRESSES & JUMPSUITS, SHORT SKIRTS.</li>
                <li><strong>Bags</strong>: TOTE BAGS, SATCHEL BAGS, WOMNEN'BACKPACKS.</li>
                <li><strong>Accessories</strong>SUNGLASSES, HATS.</li>
            </ul>

            <h2>Our Values</h2>
            <p>We always maintain our core values:</p>
            <ul>
                <li><strong>Quality</strong>: We select the finest materials and work with talented artisans to ensure each product meets our high standards.</li>
                <li><strong>Sustainability</strong>: We are committed to sustainable processes, from using environmentally friendly fabrics to reducing waste during production.</li>
                <li><strong>Inclusion</strong>: Fashion for everyone. We offer a wide range of sizes and styles to compliment every body type and personality.</li>
                <li><strong>Customer Satisfaction</strong>: Your satisfaction is our top priority. Our dedicated customer service team is always ready to assist you with any questions or requests.</li>
            </ul>

            <h2>Join Our Community</h2>
            <p>We are not just a store, but also a community of fashion enthusiasts. Follow us on social media, sign up for our newsletter, and visit our blog for styling tips, behind-the-scenes content, and special offers.</p>
        </div>
    </div>
</body>


<?php layouts('footer')?>
</html>