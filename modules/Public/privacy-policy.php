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
?>
<style>
    /* body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            margin: 0;
            padding: 0;
        }*/
    .container1 {
        max-width: 800px;
        margin: auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        margin-top: 20px;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    h3 {
        color: #555;
    }

    p {
        color: #555;
        line-height: 1.6;
    }

    ul {
        list-style-type: none;
        padding-left: 20px;
    }

    a {
        color: #28a745;
        text-decoration: none;
    }
</style>
<div class="container1">
    <h2>Privacy Policy</h2>
    <p>At BnL, we are committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website. Please read this privacy policy carefully. If you do not agree with the terms of this privacy policy, please do not access the site.</p>

    <h3>1. Information We Collect</h3>
    <p>We may collect information about you in a variety of ways. The information we may collect on the Site includes:</p>
    <ul>
        <li><strong>Personal Data:</strong> Personally identifiable information, such as your name, shipping address, email address, and telephone number, and demographic information, such as your age, gender, hometown, and interests, that you voluntarily give to us when you register with the Site or when you choose to participate in various activities related to the Site, such as online chat and message boards.</li>
        <li><strong>Derivative Data:</strong> Information our servers automatically collect when you access the Site, such as your IP address, your browser type, your operating system, your access times, and the pages you have viewed directly before and after accessing the Site.</li>
        <li><strong>Financial Data:</strong> Financial information, such as data related to your payment method (e.g., valid credit card number, card brand, expiration date) that we may collect when you purchase, order, return, exchange, or request information about our services from the Site.</li>
    </ul>

    <h3>2. Use of Your Information</h3>
    <p>Having accurate information about you permits us to provide you with a smooth, efficient, and customized experience. Specifically, we may use information collected about you via the Site to:</p>
    <ul>
        <li>Create and manage your account.</li>
        <li>Process your transactions and send you related information, including purchase confirmations and invoices.</li>
        <li>Administer promotions, surveys, and other features.</li>
        <li>Respond to your comments, questions, and requests and provide customer service.</li>
        <li>Send you technical notices, updates, security alerts, and support and administrative messages.</li>
    </ul>

    <h3>3. Disclosure of Your Information</h3>
    <p>We may share information we have collected about you in certain situations. Your information may be disclosed as follows:</p>
    <ul>
        <li><strong>By Law or to Protect Rights:</strong> If we believe the release of information about you is necessary to respond to legal process, to investigate or remedy potential violations of our policies, or to protect the rights, property, and safety of others, we may share your information as permitted or required by any applicable law, rule, or regulation.</li>
        <li><strong>Business Transfers:</strong> We may share or transfer your information in connection with, or during negotiations of, any merger, sale of company assets, financing, or acquisition of all or a portion of our business to another company.</li>
    </ul>

    <h3>4. Security of Your Information</h3>
    <p>We use administrative, technical, and physical security measures to help protect your personal information. While we have taken reasonable steps to secure the personal information you provide to us, please be aware that despite our efforts, no security measures are perfect or impenetrable, and no method of data transmission can be guaranteed against any interception or other type of misuse.</p>

    <h3>5. Policy for Children</h3>
    <p>We do not knowingly solicit information from or market to children under the age of 13. If we learn that we have collected personal information from a child under age 13 without verification of parental consent, we will delete that information as quickly as possible. If you become aware of any data we have collected from children under age 13, please contact us.</p>

    <h3>6. Changes to This Privacy Policy</h3>
    <p>We may update this Privacy Policy from time to time in order to reflect, for example, changes to our practices or for other operational, legal, or regulatory reasons.</p>

    <h3>7. Contact Us</h3>
    <p>If you have questions or comments about this Privacy Policy, please contact us at:</p>
    <ul>
        <li>Email: vana@gmail.com</li>
        <li>Phone: +84-129-12323-123123</li>
        <li>Address: 11 Nguyễn Đình Chiểu, Đa Kao, Quận 1, Thành phố Hồ Chí Minh, Việt Nam</li>
    </ul>
</div>
<div>
    <p></p>
    <h1></h1>
</div>
</body>

</html>
<?php layouts('footer') ?>