
<?php 
session_start();
if($_SESSION['role']!='user'){
  header("location: login.php");
  exit();
}
?>
<?php
session_start();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = isset($_POST['p_id']) ? intval($_POST['p_id']) : 0;
    $quantity = isset($_POST['p_qty']) ? intval($_POST['p_qty']) : 1;

    if ($product_id <= 0 || $quantity <= 0) {
        echo "Invalid product or quantity!";
        exit;
    }

    // Check karein ke product already cart mein hai ya nahi
    $check_query = "SELECT cart_id, quantity FROM cart WHERE product_id = $product_id";
    $check_result = mysqli_query($admin, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Agar hai to quantity update karein
        $cart_data = mysqli_fetch_assoc($check_result);
        $new_qty = $cart_data['quantity'] + $quantity;
        $update_query = "UPDATE cart SET quantity = $new_qty WHERE cart_id = " . $cart_data['cart_id'];
        mysqli_query($admin, $update_query);
        echo "Cart updated! Quantity increased to $new_qty";
    } else {
        // Naya item add karein
        $insert_query = "INSERT INTO cart (product_id, quantity) VALUES ($product_id, $quantity)";
        if (mysqli_query($admin, $insert_query)) {
            echo "Added to cart successfully!";
        } else {
            echo "Error: " . mysqli_error($admin);
        }
    }
} else {
    echo "Invalid request!";
}
?>