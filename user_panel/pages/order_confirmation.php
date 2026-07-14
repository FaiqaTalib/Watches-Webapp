
<?php 
session_start();
if($_SESSION['role']!='user'){
  header("location: login.php");
  exit();
}
?>
<?php
// session_start();
include('../config/db.php');

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id <= 0) {
    header('Location: index.php');
    exit;
}

$order_query = "SELECT * FROM orders WHERE order_id = $order_id";
$order_result = mysqli_query($admin, $order_query);
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    header('Location: index.html');
    exit;
}

$items_query = "SELECT oi.*, p.p_name, p.p_image, cat.c_name 
                FROM order_items oi 
                JOIN products p ON oi.product_id = p.p_id 
                JOIN category cat ON p.p_cid = cat.c_id 
                WHERE oi.order_id = $order_id";
$items_result = mysqli_query($admin, $items_query);

$order_items = [];
while ($row = mysqli_fetch_assoc($items_result)) {
    $order_items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmed — TimeZone Watches</title>
<link rel="stylesheet" href="../assets/css/style.css"/>
<style>
  /* ===== ORDER SUCCESS PAGE (ALIGNED WITH MOTHER CSS) ===== */

body {
  background: var(--black);
  color: var(--white);
  font-family: var(--font-body);
}

/* Wrapper */
.confirm-wrapper {
  max-width: 800px;
  margin: 0 auto;
  padding: 60px 20px;
}

/* Header */
.success-header {
  text-align: center;
  margin-bottom: 40px;
}

/* Icon */
.success-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  border: 2px solid var(--gold);
  color: var(--gold);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 24px;
  font-size: 26px;
}

/* Title */
.success-title {
  font-family: var(--font-display);
  font-size: 36px;
  font-weight: 300;
  margin-bottom: 8px;
  color: var(--white);
}

.success-subtitle {
  color: var(--gray);
  font-size: 13px;
  letter-spacing: 1px;
}

/* Order Number */
.order-number {
  display: inline-block;
  background: var(--dark-2);
  padding: 10px 20px;
  border-radius: 2px;
  margin-top: 20px;
  border: 1px solid var(--border);
}

.order-number .label {
  color: var(--gray);
  font-size: 11px;
  letter-spacing: 1px;
}

.order-number .value {
  color: var(--gold);
  font-weight: 600;
  font-size: 13px;
  margin-left: 6px;
}

/* Cards */
.detail-card {
  background: var(--dark-2);
  border-radius: 2px;
  padding: 28px;
  margin-bottom: 20px;
  border: 1px solid var(--border);
}

.detail-title {
  font-family: var(--font-display);
  font-size: 20px;
  margin-bottom: 18px;
  padding-bottom: 12px;
  border-bottom: 1px solid var(--border);
}

/* Rows */
.detail-row {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
  font-size: 13px;
}

.detail-row .label {
  color: var(--gray);
}

.detail-row .value {
  font-weight: 500;
  text-align: right;
}

/* Status */
.status-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 1px;
  font-size: 10px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.status-pending {
  background: rgba(201,168,76,0.1);
  color: var(--gold);
  border: 1px solid var(--border-gold);
}

/* Table */
.items-table {
  width: 100%;
  border-collapse: collapse;
}

.items-table th {
  text-align: left;
  padding: 12px;
  color: var(--gray);
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 2px;
  border-bottom: 1px solid var(--border);
}

.items-table td {
  padding: 14px 12px;
  border-bottom: 1px solid var(--border);
  vertical-align: middle;
}

/* Item */
.item-cell {
  display: flex;
  align-items: center;
  gap: 10px;
}

.item-cell img {
  width: 50px;
  height: 50px;
  object-fit: cover;
  border-radius: 1px;
  background: var(--dark-3);
  border: 1px solid var(--border);
}

.item-name {
  font-size: 13px;
  color: var(--white);
}

.item-brand {
  font-size: 10px;
  color: var(--gold);
  letter-spacing: 2px;
  text-transform: uppercase;
}

.price-cell {
  font-weight: 600;
  color: var(--gold);
}

/* Totals */
.totals-box {
  margin-top: 20px;
  padding-top: 16px;
  border-top: 1px solid var(--border);
}

.total-line {
  display: flex;
  justify-content: space-between;
  padding: 6px 0;
  font-size: 13px;
  color: var(--gray-light);
}

.total-line.grand {
  font-size: 16px;
  font-weight: 600;
  margin-top: 10px;
  padding-top: 12px;
  border-top: 1px solid var(--border);
}

.total-line.grand .amount {
  color: var(--gold);
}

/* Buttons */
.action-buttons {
  display: flex;
  gap: 12px;
  margin-top: 30px;
}

/* Use system buttons */
.btn-primary {
  flex: 1;
}

.btn-secondary {
  flex: 1;
  border: 1px solid var(--border);
  color: var(--white);
  background: transparent;
  padding: 14px;
  text-align: center;
  font-size: 11px;
  letter-spacing: 2px;
  text-transform: uppercase;
  transition: var(--transition);
}

.btn-secondary:hover {
  border-color: var(--gold);
  color: var(--gold);
}

/* Responsive */
@media (max-width: 600px) {
  .action-buttons { flex-direction: column; }
  .items-table .hide-mobile { display: none; }
}
</style>
</head>
<body>
<div class="confirm-wrapper">
  <div class="success-header">
    <div class="success-icon">✓</div>
    <h1 class="success-title">Order Placed Successfully!</h1>
    <p class="success-subtitle">Thank you for your purchase. We'll send you a confirmation email shortly.</p>
    <div class="order-number">
      <span class="label">Order #</span>
      <span class="value"><?php echo $order['order_number']; ?></span>
    </div>
  </div>
  <div class="detail-card">
    <h3 class="detail-title">Order Information</h3>
    <div class="detail-row">
      <span class="label">Order Date</span>
      <span class="value"><?php echo date('F j, Y', strtotime($order['created_at'])); ?></span>
    </div>
    <div class="detail-row">
      <span class="label">Status</span>
      <span class="value"><span class="status-badge status-pending"><?php echo ucfirst($order['status']); ?></span></span>
    </div>
    <div class="detail-row">
      <span class="label">Payment Method</span>
      <span class="value"><?php echo str_replace('_', ' ', ucfirst($order['payment_method'])); ?></span>
    </div>
    <div class="detail-row">
      <span class="label">Shipping Address</span>
      <span class="value"><?php echo $order['shipping_address']; ?></span>
    </div>
  </div>
  <div class="detail-card">
    <h3 class="detail-title">Order Items</h3>
    <table class="items-table">
      <thead>
        <tr>
          <th>Product</th>
          <th class="hide-mobile">Price</th>
          <th>Qty</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($order_items as $item): ?>
        <tr>
          <td>
            <div class="item-cell">
              <img src="../../admin panel/assets/images/<?php echo $item['p_image']; ?>" alt="<?php echo $item['p_name']; ?>">
              <div>
                <div class="item-name"><?php echo $item['p_name']; ?></div>
                <div class="item-brand"><?php echo $item['c_name']; ?></div>
              </div>
            </div>
          </td>
          <td class="hide-mobile price-cell">$<?php echo number_format($item['price'], 2); ?></td>
          <td><?php echo $item['quantity']; ?></td>
          <td class="price-cell">$<?php echo number_format($item['total'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="totals-box">
      <div class="total-line">
        <span>Subtotal</span>
        <span>$<?php echo number_format($order['subtotal'], 2); ?></span>
      </div>
      <div class="total-line">
        <span>Shipping</span>
        <span style="color: var(--success);">FREE</span>
      </div>
      <div class="total-line">
        <span>Tax</span>
        <span>$<?php echo number_format($order['tax'], 2); ?></span>
      </div>
      <div class="total-line grand">
        <span>Total</span>
        <span class="amount">$<?php echo number_format($order['total'], 2); ?></span>
      </div>
    </div>
  </div>
  <div class="action-buttons">
    <a href="my_orders.php" class="btn btn-primary">View My Orders</a>
    <a href="products.php" class="btn btn-secondary">Continue Shopping</a>
  </div>
</div>
</body>
</html>