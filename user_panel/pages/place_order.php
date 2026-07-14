<?php
session_start();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cart.php');
    exit;
}

$first_name = mysqli_real_escape_string($admin, $_POST['first_name']);
$last_name = mysqli_real_escape_string($admin, $_POST['last_name']);
$email = mysqli_real_escape_string($admin, $_POST['email']);
$phone = mysqli_real_escape_string($admin, $_POST['phone']);
$address = mysqli_real_escape_string($admin, $_POST['address']);
$city = mysqli_real_escape_string($admin, $_POST['city']);
$zip = mysqli_real_escape_string($admin, $_POST['zip']);
$country = mysqli_real_escape_string($admin, $_POST['country']);
$payment_method = mysqli_real_escape_string($admin, $_POST['payment_method']);
$notes = mysqli_real_escape_string($admin, $_POST['notes'] ?? '');

$customer_name = $first_name . ' ' . $last_name;
$full_address = $address . ', ' . $city . ', ' . $zip . ', ' . $country;

$cart_query = "SELECT c.*, p.p_price FROM cart c JOIN products p ON c.product_id = p.p_id";
$cart_result = mysqli_query($admin, $cart_query);

$subtotal = 0;
$cart_items = [];
while ($row = mysqli_fetch_assoc($cart_result)) {
    $subtotal += $row['p_price'] * $row['quantity'];
    $cart_items[] = $row;
}

$tax = $subtotal * 0.05;
$shipping = 0;
$total = $subtotal + $tax + $shipping;

$order_number = 'TZ-' . date('Ymd') . '-' . rand(1000, 9999);

$order_query = "INSERT INTO orders (order_number, customer_name, customer_email, customer_phone, 
               shipping_address, payment_method, subtotal, tax, shipping, total, notes, status) 
               VALUES ('$order_number', '$customer_name', '$email', '$phone', 
               '$full_address', '$payment_method', $subtotal, $tax, $shipping, $total, '$notes', 'pending')";

if (mysqli_query($admin, $order_query)) {
    $order_id = mysqli_insert_id($admin);
    
    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['p_price'];
        $item_total = $price * $quantity;
        
        $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price, total) 
                       VALUES ($order_id, $product_id, $quantity, $price, $item_total)";
        mysqli_query($admin, $item_query);
    }
    
    mysqli_query($admin, "DELETE FROM cart");
    
    header('Location: order_confirmation.php?order_id=' . $order_id);
    exit;
} else {
    echo "Error placing order: " . mysqli_error($admin);
}
?>