<!-- connect file -->
<?php
include("includes/db.connection.php");
session_start();

// Ensure cart exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

function sanitize_price($price) {
    // Remove commas and convert to float
    return (float) str_replace(',', '', $price);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iTech Cart</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <div class="container layout_padding">
        <h1 class="fashion_taital">Your Shopping Cart</h1>

        <?php if (empty($_SESSION['cart'])): ?>
            <div class="alert alert-warning text-center">
                Your cart is empty. 
                <a href="home.php" class="btn btn-primary" style="background-color: #f26522; color: white; border: none;">Continue shopping</a>
            </div>
        <?php else: ?>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $item): 
                        $price = sanitize_price($item['price']);
                        $itemTotal = $price * $item['quantity'];
                        $total += $itemTotal;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>₱<?php echo number_format($price, 2); ?></td>
                            <td><?php echo (int) $item['quantity']; ?></td>
                            <td>₱<?php echo number_format($itemTotal, 2); ?></td>
                            <td>
                                <a href="edit_cart.php?id=<?php echo urlencode($item['id']); ?>" 
                                   class="btn btn-primary btn-sm">
                                   <i class="bi bi-pencil"></i> Edit
                                </a>
                               <a href="remove_cart.php?id=<?php echo urlencode($item['id']); ?>" class="btn btn-danger btn-sm">
  🗑️ Delete
</a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3 class="text-right">Total: ₱<?php echo number_format($total, 2); ?></h3>
            <div class="text-right">
                <a href="checkout.php" class="btn btn-lg" style="background-color: #f26522; color: white; border: none;">
                    Proceed to Checkout
                </a>
            </div>

        <?php endif; ?>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
