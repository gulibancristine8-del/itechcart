<?php
session_start();

if (!isset($_POST['total_amount'])) {
    die("Invalid access. No total amount found.");
}

$total_amount = floatval($_POST['total_amount']);

// Set the session variable so gcash3.php can use it
$_SESSION['total_amount'] = $total_amount;
?>

<!-- Your ORIGINAL gcash1.php HTML STARTS HERE -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GCash Payment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      background-color: #ffffff;
      width: 100%;
      max-width: 400px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .header {
      background-color: #0072CE;
      color: white;
      text-align: center;
      padding: 20px;
    }

    .details {
      background-color: #f2f2f2;
      padding: 15px 20px;
      text-align: left;
    }

    .details p {
      margin: 5px 0;
      font-size: 16px;
    }

    .form {
      padding: 20px;
    }

    .form p {
      margin-bottom: 10px;
      color: #333;
      font-size: 16px;
    }

    .form input {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
    }

    .form button {
      width: 100%;
      padding: 12px;
      background-color: #0072CE;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    .form button:hover {
      background-color: #005fa3;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="header">
    <h2>GCash</h2>
  </div>

  <div class="details">
    <p><strong>Merchant:</strong> I-TECH CART</p>
    <p><strong>Amount Due:</strong> ₱<?= number_format($total_amount, 2) ?></p>
  </div>

  <form class="form" action="gcash2.html" method="POST">
    <p>Enter your mobile number</p>
    <input type="tel" name="mobile" placeholder="09XXXXXXXXX" required>
    <input type="hidden" name="total_amount" value="<?= $total_amount ?>">
    <button type="submit">NEXT</button>
  </form>
</div>

</body>
</html>