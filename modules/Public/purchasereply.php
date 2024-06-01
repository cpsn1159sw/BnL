<?php
// Restrict unauthorized access
if(!defined('_CODE')) {
    die('Access denied...');
}

if(!isLogin()) {
    redirect('/BnL/user/login');
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BnL - Return Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
        }
        .container {
            max-width: 600px;
            margin: auto;
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
        <h2>Return Request</h2>
        <form action="process_return.php" method="post" enctype="multipart/form-data">
            <label for="order_id">Order ID:</label>
            <input type="text" id="order_id" name="order_id" required>
            <div class="note">Please enter the order ID you want to return.</div>

            <label for="product_id">Product ID:</label>
            <input type="text" id="product_id" name="product_id" required>
            <div class="note">Please enter the product ID you want to return.</div>

            <label for="reason">Reason for Return:</label>
            <textarea id="reason" name="reason" rows="4" required></textarea>
            <div class="note">Please describe in detail the reason for your return.</div>

            <label for="invoice">Purchase Invoice:</label>
            <input type="file" id="invoice" name="invoice" accept="image/*,application/pdf" required>
            <div class="note">Please upload the purchase invoice in image or PDF format.</div>

            <button type="submit">Submit Request</button>
        </form>
    </div>
</body>
</html>
```