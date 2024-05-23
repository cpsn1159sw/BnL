<?php
// Chặn truy cập hợp lệ
    if(!defined('_CODE')) {
        die('Access denied...');
    }
    
// Thông tin kết nối 
const _HOST = 'localhost';
const _DB = 'db_shop';
const _USER = 'root';
const _PASS = '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu cầu đổi trả hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }
        input, textarea, select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
        }
        button {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .note {
            font-size: 14px;
            color: #888;
            margin-top: -15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Yêu cầu đổi trả hàng</h2>
        <form action="process_return.php" method="post" enctype="multipart/form-data">
            <label for="order_id">Mã đơn hàng:</label>
            <input type="text" id="order_id" name="order_id" required>
            <div class="note">Vui lòng nhập mã đơn hàng mà bạn muốn đổi trả.</div>

            <label for="product_id">Mã sản phẩm:</label>
            <input type="text" id="product_id" name="product_id" required>
            <div class="note">Vui lòng nhập mã sản phẩm mà bạn muốn đổi trả.</div>

            <label for="reason">Lý do đổi trả:</label>
            <textarea id="reason" name="reason" rows="4" required></textarea>
            <div class="note">Vui lòng mô tả chi tiết lý do bạn muốn đổi trả sản phẩm.</div>

            <label for="invoice">Hóa đơn mua hàng:</label>
            <input type="file" id="invoice" name="invoice" accept="image/*,application/pdf" required>
            <div class="note">Vui lòng tải lên hóa đơn mua hàng dưới định dạng ảnh hoặc PDF.</div>

<button type="submit">Gửi yêu cầu</button>
</form>
</div>
</body>
</html>
