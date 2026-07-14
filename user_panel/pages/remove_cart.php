<?php
include('../config/db.php');

$cart_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($cart_id > 0) {
    $query = "DELETE FROM cart WHERE cart_id = $cart_id";
    if (mysqli_query($admin, $query)) {
        header('Location: cart.php');
        exit;
    } else {
        echo "Error removing item: " . mysqli_error($admin);
    }
} else {
    header('Location: cart.php');
    exit;
}
?>