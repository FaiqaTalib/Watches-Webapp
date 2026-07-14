<?php
// Yeh code apne header/navigation file mein top pe add karein
include('../config/db.php');
$cart_count_query = "SELECT SUM(quantity) as total FROM cart";
$cart_count_result = mysqli_query($admin, $cart_count_query);
$cart_count = mysqli_fetch_assoc($cart_count_result)['total'] ?? 0;
?>

<!-- Navigation mein cart link -->
<a href="cart.php" class="cart-icon">
  🛒 Cart
  <?php if ($cart_count > 0): ?>
  <span class="cart-badge"><?php echo $cart_count; ?></span>
  <?php endif; ?>
</a>