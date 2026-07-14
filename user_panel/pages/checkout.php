
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

$query = "SELECT c.cart_id, c.product_id, c.quantity, p.p_name, p.p_price, p.p_image, p.p_desc, cat.c_name FROM cart c JOIN products p ON c.product_id = p.p_id JOIN category cat ON p.p_cid = cat.c_id";
$result = mysqli_query($admin, $query);

$cart_items = [];
$subtotal = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $row['subtotal'] = $row['p_price'] * $row['quantity'];
    $subtotal += $row['subtotal'];
    $cart_items[] = $row;
}

$tax = $subtotal * 0.05;
$total = $subtotal + $tax;

if (empty($cart_items)) {
    header('Location: cart.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout — TimeZone Watches</title>
<link rel="stylesheet" href="../assets/css/style.css"/>
<style>
/* ===== CHECKOUT PAGE (ALIGNED WITH MOTHER CSS) ===== */

body {
  background: var(--black);
  color: var(--white);
  font-family: var(--font-body);
}

/* Header */
.checkout-header {
  background: var(--dark);
  border-bottom: 1px solid var(--border);
  padding: 20px 0;
}

.header-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  font-family: var(--font-display);
  font-size: 22px;
  color: var(--white);
  letter-spacing: 2px;
}

.logo span {
  color: var(--gold);
}

.secure-badge {
  display: flex;
  align-items: center;
  gap: 8px;
  color: var(--gray);
  font-size: 11px;
  letter-spacing: 1px;
}

/* Layout */
.checkout-wrapper {
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 20px;
}

.checkout-grid {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 40px;
}

/* Section Title */
.section-title {
  font-family: var(--font-display);
  font-size: 22px;
  font-weight: 400;
  margin-bottom: 24px;
  color: var(--white);
  display: flex;
  align-items: center;
  gap: 12px;
}

.section-title .num {
  width: 26px;
  height: 26px;
  background: var(--gold);
  color: var(--black);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 700;
}

/* Form Section */
.form-section {
  background: var(--dark-2);
  border-radius: 2px;
  padding: 30px;
  margin-bottom: 20px;
  border: 1px solid var(--border);
}

/* Form */
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.form-group {
  margin-bottom: 16px;
}

.form-group.full {
  grid-column: 1 / -1;
}

.form-label {
  font-size: 10px;
  color: var(--gray);
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.form-input {
  width: 100%;
  padding: 13px 16px;
  background: var(--dark-3);
  border: 1px solid var(--border);
  border-radius: 2px;
  color: var(--white);
  font-size: 13px;
  transition: var(--transition);
}

.form-input:focus {
  border-color: var(--border-gold);
  background: var(--dark-2);
}

.form-input::placeholder {
  color: var(--gray);
}

/* Payment */
.payment-methods {
  display: grid;
  gap: 10px;
}

.payment-option {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 14px;
  background: var(--dark-3);
  border: 1px solid var(--border);
  border-radius: 2px;
  cursor: pointer;
  transition: var(--transition);
}

.payment-option:hover {
  border-color: var(--border-gold);
}

.payment-option input[type="radio"] {
  accent-color: var(--gold);
}

.payment-option label {
  flex: 1;
  font-size: 13px;
}

/* Sidebar */
.summary-sidebar {
  background: var(--dark-2);
  border-radius: 2px;
  padding: 28px;
  border: 1px solid var(--border);
  height: fit-content;
  position: sticky;
  top: 90px;
}

/* Summary */
.summary-title {
  font-family: var(--font-display);
  font-size: 20px;
  margin-bottom: 20px;
  padding-bottom: 14px;
  border-bottom: 1px solid var(--border);
}

/* Items */
.order-item {
  display: flex;
  gap: 12px;
  padding: 12px 0;
  border-bottom: 1px solid var(--border);
}

.order-item img {
  width: 56px;
  height: 56px;
  object-fit: cover;
  border-radius: 2px;
  background: var(--dark-3);
}

.order-item-name {
  font-size: 13px;
  color: var(--white);
}

.order-item-meta {
  font-size: 11px;
  color: var(--gray);
}

.order-item-price {
  margin-left: auto;
  color: var(--gold);
  font-weight: 600;
}

/* Totals */
.totals-section {
  margin-top: 20px;
  padding-top: 16px;
  border-top: 1px solid var(--border);
}

.total-row {
  display: flex;
  justify-content: space-between;
  font-size: 13px;
  color: var(--gray-light);
  padding: 8px 0;
}

.total-row.grand-total {
  font-size: 16px;
  font-weight: 600;
  border-top: 1px solid var(--border);
  margin-top: 10px;
  padding-top: 12px;
}

.total-row.grand-total .value {
  color: var(--gold);
}

/* Button */
.place-order-btn {
  width: 100%;
  padding: 14px;
  margin-top: 20px;
  background: var(--gold);
  color: var(--black);
  border-radius: 1px;
  font-size: 11px;
  font-weight: 700;
  cursor: pointer;
  transition: var(--transition);
  text-transform: uppercase;
  letter-spacing: 2px;
}

.place-order-btn:hover {
  background: var(--gold-light);
  box-shadow: var(--shadow-gold);
}

/* Responsive */
@media (max-width: 768px) {
  .checkout-grid { grid-template-columns: 1fr; }
  .form-row { grid-template-columns: 1fr; }
  .summary-sidebar { position: static; }
}
</style>
</head>
<body>
<div class="checkout-header">
  <div class="header-inner">
    <a href="index.html" class="logo">⌚ TimeZone</a>
    <div class="secure-badge">🔒 Secure Checkout</div>
  </div>
</div>
<div class="checkout-wrapper">
  <form action="place_order.php" method="POST" id="checkoutForm">
    <div class="checkout-grid">
      <div class="checkout-form">
        <div class="form-section">
          <h2 class="section-title"><span class="num">1</span> Shipping Information</h2>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">First Name</label>
              <input type="text" name="first_name" class="form-input" placeholder="John" required>
            </div>
            <div class="form-group">
              <label class="form-label">Last Name</label>
              <input type="text" name="last_name" class="form-input" placeholder="Doe" required>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-input" placeholder="john@example.com" required>
          </div>
          <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone" class="form-input" placeholder="+1 234 567 890" required>
          </div>
          <div class="form-group">
            <label class="form-label">Street Address</label>
            <input type="text" name="address" class="form-input" placeholder="123 Main Street" required>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">City</label>
              <input type="text" name="city" class="form-input" placeholder="New York" required>
            </div>
            <div class="form-group">
              <label class="form-label">ZIP Code</label>
              <input type="text" name="zip" class="form-input" placeholder="10001" required>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Country</label>
            <input type="text" name="country" class="form-input" placeholder="United States" required>
          </div>
        </div>
        <div class="form-section">
          <h2 class="section-title"><span class="num">2</span> Payment Method</h2>
          <div class="payment-methods">
            <div class="payment-option">
              <input type="radio" name="payment_method" id="cod" value="cod" checked>
              <label for="cod">💵 Cash on Delivery</label>
            </div>
            <div class="payment-option">
              <input type="radio" name="payment_method" id="card" value="card">
              <label for="card">💳 Credit / Debit Card</label>
            </div>
            <div class="payment-option">
              <input type="radio" name="payment_method" id="bank" value="bank_transfer">
              <label for="bank">🏦 Bank Transfer</label>
            </div>
          </div>
          <div class="form-group" style="margin-top: 20px;">
            <label class="form-label">Order Notes (Optional)</label>
            <textarea name="notes" class="form-input" rows="3" placeholder="Special instructions for delivery..."></textarea>
          </div>
        </div>
      </div>
      <div class="summary-sidebar">
        <h3 class="summary-title">Order Summary</h3>
        <?php foreach ($cart_items as $item): ?>
        <div class="order-item">
          <img src="../../admin panel/assets/images/<?php echo $item['p_image']; ?>" alt="<?php echo $item['p_name']; ?>">
          <div class="order-item-info">
            <div class="order-item-name"><?php echo $item['p_name']; ?></div>
            <div class="order-item-meta"><?php echo $item['c_name']; ?> × <?php echo $item['quantity']; ?></div>
          </div>
          <div class="order-item-price">$<?php echo number_format($item['subtotal'], 2); ?></div>
        </div>
        <?php endforeach; ?>
        <div class="totals-section">
          <div class="total-row">
            <span class="label">Subtotal</span>
            <span class="value">$<?php echo number_format($subtotal, 2); ?></span>
          </div>
          <div class="total-row free">
            <span class="label">Shipping</span>
            <span class="value">FREE</span>
          </div>
          <div class="total-row">
            <span class="label">Tax (5%)</span>
            <span class="value">$<?php echo number_format($tax, 2); ?></span>
          </div>
          <div class="total-row grand-total">
            <span class="label">Total</span>
            <span class="value">$<?php echo number_format($total, 2); ?></span>
          </div>
        </div>
        <button type="submit" class="place-order-btn">Place Order →</button>
      </div>
    </div>
  </form>
</div>
</body>
</html>