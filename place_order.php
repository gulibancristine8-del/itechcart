<?php
include("includes/db.connection.php");
session_start();

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$fullname       = trim($_POST['fullname']);
$address        = trim($_POST['address']);
$payment_method = trim($_POST['payment_method']);

if (empty($fullname) || empty($address) || empty($payment_method)) {
    die("Error: Please fill in all required fields.");
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $price = floatval(str_replace(',', '', $item['price']));
    $total += $price * $item['quantity'];
}

$order_date = date('Y-m-d H:i:s');

$sql = "INSERT INTO orders (fullname, address, payment_method, total_amount, order_date) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssds", $fullname, $address, $payment_method, $total, $order_date);

if (mysqli_stmt_execute($stmt)) {
    $order_id = mysqli_insert_id($conn);

    foreach ($_SESSION['cart'] as $item) {
        $price = floatval(str_replace(',', '', $item['price']));
        $sql_item = "INSERT INTO order_items (order_id, product_name, price, quantity) 
                     VALUES (?, ?, ?, ?)";
        $stmt_item = mysqli_prepare($conn, $sql_item);
        mysqli_stmt_bind_param($stmt_item, "isdi", $order_id, $item['name'], $price, $item['quantity']);
        mysqli_stmt_execute($stmt_item);
    }

    unset($_SESSION['cart']);
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Confirmation</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f8f9fa;
                margin: 0;
                padding: 0;
            }
            .checkout-container {
                max-width: 500px;
                margin: 80px auto;
                background: #ffffff;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                text-align: center;
                animation: fadeIn 0.5s ease-in-out;
            }
            h2 {
                color: #000000ff;
                margin-bottom: 15px;
            }
            p {
                font-size: 16px;
                color: #555;
                margin: 8px 0;
            }
            b {
                color: #000;
            }
            a {
                display: inline-block;
                margin-top: 20px;
                padding: 12px 25px;
                background: #f26522;
                color: #fff;
                text-decoration: none;
                border-radius: 8px;
                font-weight: bold;
                transition: background 0.3s ease;
            }
            a:hover {
                background: #d35400;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body>
        <div class="checkout-container">
            <h2>Order Placed Successfully!</h2>
            <p>Your Order ID: <b><?php echo $order_id; ?></b></p>
            <p>Total Amount: ₱<?php echo number_format($total, 2); ?></p>
            <p>Thank you for shopping with us! Your order will be processed soon.</p>
            <a href="home.php">Go Back to Shop</a>
        </div>
    </body>
    </html>

    <?php
} else {
    echo "Error placing order: " . mysqli_error($conn);
}
?>
