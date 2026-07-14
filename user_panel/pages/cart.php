
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

$query = "SELECT c.cart_id, c.product_id, c.quantity, c.added_at, 
          p.p_name, p.p_price, p.p_image, p.p_desc, cat.c_name 
          FROM cart c 
          JOIN products p ON c.product_id = p.p_id 
          JOIN category cat ON p.p_cid = cat.c_id 
          ORDER BY c.added_at DESC";
$result = mysqli_query($admin, $query);

$cart_items = [];
$total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $row['subtotal'] = $row['p_price'] * $row['quantity'];
    $total += $row['subtotal'];
    $cart_items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Cart — TimeZone Watches</title>
<link rel="stylesheet" href="../assets/css/style.css"/>
<style>
/* ===== CART PAGE (FIXED ACCORDING TO MOTHER CSS) ===== */

body {
  background: var(--black);
  font-family: var(--font-body);
  color: var(--white);
}

.cart-wrapper {
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 20px;
}

/* Titles */
.cart-title {
  font-family: var(--font-display);
  font-size: 42px;
  font-weight: 400;
  margin-bottom: 8px;
  color: var(--white);
  letter-spacing: 2px;
}

.cart-subtitle {
  color: var(--gray);
  margin-bottom: 35px;
  font-size: 13px;
}

/* Layout */
.cart-layout {
  display: grid;
  grid-template-columns: 1.6fr 1fr;
  gap: 30px;
}

/* Cart Items */
.cart-items-box {
  background: var(--dark-2);
  border: 1px solid var(--border);
  border-radius: 2px;
  padding: 30px;
  box-shadow: var(--shadow);
}

.item-count {
  font-size: 11px;
  color: var(--gray);
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 1px solid var(--border);
  letter-spacing: 1px;
}

.cart-item {
  display: flex;
  gap: 20px;
  padding: 24px 0;
  border-bottom: 1px solid var(--border);
  align-items: center;
  transition: var(--transition);
}

.cart-item:hover {
  background: rgba(255,255,255,0.01);
}

.cart-item:last-child {
  border-bottom: none;
}

.item-image {
  width: 110px;
  height: 110px;
  object-fit: cover;
  border-radius: 2px;
  background: var(--dark-3);
  border: 1px solid var(--border);
}

/* Details */
.item-details { flex: 1; }

.item-name {
  font-family: var(--font-display);
  font-size: 18px;
  font-weight: 400;
  color: var(--white);
  margin-bottom: 6px;
}

.item-brand {
  color: var(--gold);
  font-size: 10px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 8px;
}

.item-price {
  font-size: 14px;
  font-weight: 600;
  color: var(--white);
}

/* Controls */
.item-controls {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-top: 12px;
}

.qty-control {
  display: flex;
  align-items: center;
  border: 1px solid var(--border);
  border-radius: 2px;
  overflow: hidden;
}

.qty-btn-sm {
  width: 34px;
  height: 34px;
  background: var(--dark-2);
  cursor: pointer;
  font-size: 14px;
  color: var(--white);
  transition: var(--transition);
}

.qty-btn-sm:hover {
  color: var(--gold);
}

.qty-value {
  width: 40px;
  text-align: center;
  font-weight: 600;
  font-size: 12px;
  border-left: 1px solid var(--border);
  border-right: 1px solid var(--border);
  padding: 8px 0;
  background: var(--dark);
  color: var(--white);
}

/* Remove */
.remove-link {
  color: #c0392b;
  font-size: 11px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 4px;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.remove-link:hover {
  opacity: 0.7;
}

/* Total */
.item-total {
  text-align: right;
  min-width: 100px;
}

.total-price {
  font-size: 16px;
  font-weight: 600;
  color: var(--gold);
}

/* ===== SUMMARY ===== */
.summary-box {
  background: var(--dark-2);
  border: 1px solid var(--border);
  border-radius: 2px;
  padding: 30px;
  height: fit-content;
  position: sticky;
  top: 90px;
}

.summary-title {
  font-family: var(--font-display);
  font-size: 22px;
  font-weight: 400;
  margin-bottom: 24px;
  color: var(--white);
  border-bottom: 1px solid var(--border);
  padding-bottom: 16px;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  padding: 10px 0;
  color: var(--gray-light);
  font-size: 13px;
}

.summary-row.divider {
  border-top: 1px solid var(--border);
  margin-top: 10px;
  padding-top: 16px;
}

.summary-row.total {
  font-size: 16px;
  font-weight: 600;
  color: var(--white);
}

.summary-row.total span:last-child {
  color: var(--gold);
}

.summary-row .free {
  color: var(--gold);
  font-weight: 600;
}

/* Checkout Button (use theme) */
.checkout-btn {
  width: 100%;
  padding: 14px;
  background: var(--gold);
  color: var(--black);
  border-radius: 1px;
  font-size: 11px;
  font-weight: 700;
  cursor: pointer;
  margin-top: 20px;
  transition: var(--transition);
  text-transform: uppercase;
  letter-spacing: 2px;
}

.checkout-btn:hover {
  background: var(--gold-light);
  box-shadow: var(--shadow-gold);
}

/* Continue */
.continue-link {
  display: block;
  text-align: center;
  margin-top: 16px;
  color: var(--gray);
  font-size: 11px;
  letter-spacing: 1px;
}

.continue-link:hover {
  color: var(--gold);
}

/* Empty */
.empty-state {
  text-align: center;
  padding: 80px 20px;
  background: var(--dark-2);
  border: 1px solid var(--border);
}

.empty-title {
  font-family: var(--font-display);
  font-size: 32px;
  color: var(--white);
  margin-bottom: 10px;
}

.empty-text {
  color: var(--gray);
  margin-bottom: 30px;
}

/* Use existing button system */
.shop-btn {
  display: inline-block;
}

/* Responsive */
@media (max-width: 768px) {
  .cart-layout { grid-template-columns: 1fr; }
  .cart-item { flex-direction: column; text-align: center; }
  .item-controls { justify-content: center; }
  .item-total { text-align: center; }
}
</style>
</head>
<body>

<div class="page-header">
  <div class="page-header-inner">
    <h1 class="page-title">Shopping Cart</h1>
    <div class="breadcrumb">
      <a href="index.html">Home</a><span>/</span>
      <span>Cart</span>
    </div>
  </div>
</div>

<div class="cart-wrapper">
  <?php if (empty($cart_items)): ?>
    <div class="empty-state">
      <div class="empty-icon">🛒</div>
      <h2 class="empty-title">Your cart is empty</h2>
      <p class="empty-text">Discover our exclusive timepieces collection</p>
      <a href="products.html" class="shop-btn">Start Shopping</a>
    </div>
  <?php else: ?>
    <h1 class="cart-title">Shopping Cart</h1>
    <p class="cart-subtitle"><?php echo count($cart_items); ?> items in your cart</p>
    
    <div class="cart-layout">
      <div class="cart-items-box">
        <div class="item-count"><?php echo count($cart_items); ?> Item(s)</div>
        
        <?php foreach ($cart_items as $item): ?>
        <div class="cart-item" data-cart-id="<?php echo $item['cart_id']; ?>">
          <img src="../../admin panel/assets/images/<?php echo $item['p_image']; ?>" class="item-image" alt="<?php echo $item['p_name']; ?>">
          
          <div class="item-details">
            <div class="item-name"><?php echo $item['p_name']; ?></div>
            <div class="item-brand"><?php echo $item['c_name']; ?></div>
            <div class="item-price">$<?php echo number_format($item['p_price'], 2); ?> each</div>
            
            <div class="item-controls">
              <div class="qty-control">
                <button class="qty-btn-sm cart-minus" data-id="<?php echo $item['cart_id']; ?>">−</button>
                <span class="qty-value"><?php echo $item['quantity']; ?></span>
                <button class="qty-btn-sm cart-plus" data-id="<?php echo $item['cart_id']; ?>">+</button>
              </div>
              <a href="remove_cart.php?id=<?php echo $item['cart_id']; ?>" class="remove-link" onclick="return confirm('Remove this item?')">🗑 Remove</a>
            </div>
          </div>
          
          <div class="item-total">
            <div class="total-price">$<?php echo number_format($item['subtotal'], 2); ?></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      
      <div class="summary-box">
        <h3 class="summary-title">Order Summary</h3>
        
        <div class="summary-row">
          <span>Subtotal</span>
          <span>$<?php echo number_format($total, 2); ?></span>
        </div>
        <div class="summary-row">
          <span>Shipping</span>
          <span class="free">FREE</span>
        </div>
        <div class="summary-row">
          <span>Tax</span>
          <span>Calculated at checkout</span>
        </div>
        <div class="summary-row divider total">
          <span>Total</span>
          <span>$<?php echo number_format($total, 2); ?></span>
        </div>
        
        <button class="checkout-btn"><a href="checkout.php">Proceed to Checkout</a> →</button>
        <a href="products.html" class="continue-link">← Continue Shopping</a>
      </div>
    </div>
  <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.cart-plus, .cart-minus').click(function() {
        const cartId = $(this).data('id');
        const isPlus = $(this).hasClass('cart-plus');
        const qtySpan = $(this).siblings('.qty-value');
        let currentQty = parseInt(qtySpan.text());
        
        if (isPlus) currentQty++;
        else if (currentQty > 1) currentQty--;
        
        $.ajax({
            url: 'update_cart.php',
            method: 'POST',
            data: { cart_id: cartId, quantity: currentQty },
            success: function(response) {
                if (response === 'success') location.reload();
            }
        });
    });
});
</script>

</body>

<script src="../assets/js/layout.js"></script>
</html>