<?php
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($cart_id > 0 && $quantity > 0) {
        $query = "UPDATE cart SET quantity = $quantity WHERE cart_id = $cart_id";
        if (mysqli_query($admin, $query)) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
}
?>