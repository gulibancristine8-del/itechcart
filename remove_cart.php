<?php
session_start();

if (isset($_GET['id']) && isset($_SESSION['cart'])) {
    $productId = $_GET['id'];

    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] == $productId) {
            unset($_SESSION['cart'][$index]);
            break;
        }
    }

    // Reindex para walang gap sa indexes
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header("Location: cart.php");
exit();
