<?php
session_start();

$id = $_POST['product_id'];
$qty = $_POST['quantity'];

if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id] += $qty;
}else{
    $_SESSION['cart'][$id] = $qty;
}

echo "Added";
?>