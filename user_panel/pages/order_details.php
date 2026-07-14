
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

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($order_id <= 0) {
    header('Location: my_orders.php');
    exit;
}

$order_query = "SELECT * FROM orders WHERE order_id = $order_id";
$order_result = mysqli_query($admin, $order_query);
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    header('Location: my_orders.php');
    exit;
}

$items_query = "SELECT oi.*, p.p_name, p.p_image, p.p_desc, cat.c_name 
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
<title>Order #<?php echo $order['order_number']; ?> — TimeZone Watches</title>
<link rel="stylesheet" href="../assets/css/style.css"/>
<style>
  /* ===== ORDER DETAIL PAGE (ALIGNED WITH MOTHER CSS) ===== */

body {
  background: var(--black);
  color: var(--white);
  font-family: var(--font-body);
}

/* Container */
.container {
  max-width: 900px;
  margin: 0 auto;
  padding: 100px 20px;
}

/* Header */
.detail-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  flex-wrap: wrap;
  gap: 16px;
}

.back-link {
  color: var(--gray);
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.back-link:hover {
  color: var(--gold);
}

/* Title */
.order-title {
  font-family: var(--font-display);
  font-size: 28px;
  font-weight: 400;
  letter-spacing: 1px;
}

.order-title span {
  color: var(--gold);
}

/* Status */
.status-badge-lg {
  padding: 6px 14px;
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

.status-processing {
  background: rgba(230,126,34,0.1);
  color: #e67e22;
}

.status-shipped {
  background: rgba(52,152,219,0.1);
  color: #3498db;
}

.status-delivered {
  background: rgba(39,174,96,0.1);
  color: #27ae60;
}

.status-cancelled {
  background: rgba(192,57,43,0.1);
  color: #c0392b;
}

/* Cards */
.info-card {
  background: var(--dark-2);
  border-radius: 2px;
  padding: 28px;
  margin-bottom: 20px;
  border: 1px solid var(--border);
}

.card-title {
  font-family: var(--font-display);
  font-size: 20px;
  margin-bottom: 18px;
  padding-bottom: 12px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  gap: 8px;
}

/* Info Grid */
.info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 14px;
}

.info-label {
  font-size: 10px;
  color: var(--gray);
  text-transform: uppercase;
  letter-spacing: 2px;
}

.info-value {
  font-size: 13px;
  color: var(--white);
}

/* Timeline */
.timeline {
  display: flex;
  justify-content: space-between;
  margin: 20px 0;
  position: relative;
}

.timeline::before {
  content: '';
  position: absolute;
  top: 14px;
  left: 0;
  right: 0;
  height: 1px;
  background: var(--border);
}

.timeline-step {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  position: relative;
  z-index: 1;
}

.step-dot {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: var(--dark);
  border: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 10px;
}

.step-dot.active {
  background: var(--gold);
  border-color: var(--gold);
  color: var(--black);
}

.step-dot.completed {
  background: var(--gold);
  border-color: var(--gold);
  color: var(--black);
}

.step-label {
  font-size: 10px;
  color: var(--gray);
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* Items */
.item-row {
  display: flex;
  gap: 14px;
  padding: 14px 0;
  border-bottom: 1px solid var(--border);
  align-items: center;
}

.item-row:last-child {
  border-bottom: none;
}

.item-row img {
  width: 70px;
  height: 70px;
  object-fit: cover;
  border-radius: 1px;
  background: var(--dark-3);
  border: 1px solid var(--border);
}

.item-name {
  font-size: 14px;
  color: var(--white);
}

.item-meta {
  font-size: 11px;
  color: var(--gray);
  letter-spacing: 1px;
}

.item-price {
  font-weight: 600;
  color: var(--gold);
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
  padding: 6px 0;
  font-size: 13px;
  color: var(--gray-light);
}

.total-row.grand {
  font-size: 16px;
  font-weight: 600;
  margin-top: 10px;
  padding-top: 12px;
  border-top: 1px solid var(--border);
}

.total-row.grand .value {
  color: var(--gold);
}

/* Responsive */
@media (max-width: 600px) {
  .info-grid { grid-template-columns: 1fr; }
  .timeline { flex-direction: column; gap: 16px; }
  .timeline::before { display: none; }
}
</style>
</head>
<body>
  
<div class="container">
  <div class="detail-header">
    <div>
      <a href="my_orders.php" class="back-link">← Back to Orders</a>
      <h1 class="order-title">Order <span>#<?php echo $order['order_number']; ?></span></h1>
    </div>
    <span class="status-badge-lg status-<?php echo $order['status']; ?>">
      <?php echo ucfirst($order['status']); ?>
    </span>
  </div>
  <div class="info-card">
    <h3 class="card-title">📍 Order Status</h3>
    <div class="timeline">
      <div class="timeline-step">
        <div class="step-dot <?php echo in_array($order['status'], ['pending','processing','shipped','delivered']) ? 'completed' : ''; ?>">✓</div>
        <span class="step-label">Ordered</span>
      </div>
      <div class="timeline-step">
        <div class="step-dot <?php echo in_array($order['status'], ['processing','shipped','delivered']) ? 'completed' : ($order['status'] == 'pending' ? 'active' : ''); ?>">
          <?php echo in_array($order['status'], ['processing','shipped','delivered']) ? '✓' : '2'; ?>
        </div>
        <span class="step-label">Processing</span>
      </div>
      <div class="timeline-step">
        <div class="step-dot <?php echo in_array($order['status'], ['shipped','delivered']) ? 'completed' : ($order['status'] == 'processing' ? 'active' : ''); ?>">
          <?php echo in_array($order['status'], ['shipped','delivered']) ? '✓' : '3'; ?>
        </div>
        <span class="step-label">Shipped</span>
      </div>
      <div class="timeline-step">
        <div class="step-dot <?php echo $order['status'] == 'delivered' ? 'completed' : ($order['status'] == 'shipped' ? 'active' : ''); ?>">
          <?php echo $order['status'] == 'delivered' ? '✓' : '4'; ?>
        </div>
        <span class="step-label">Delivered</span>
      </div>
    </div>
  </div>
  <div class="info-card">
    <h3 class="card-title">📋 Order Details</h3>
    <div class="info-grid">
      <div class="info-item">
        <span class="info-label">Order Date</span>
        <span class="info-value"><?php echo date('F j, Y \a\t g:i A', strtotime($order['created_at'])); ?></span>
      </div>
      <div class="info-item">
        <span class="info-label">Payment Method</span>
        <span class="info-value"><?php echo str_replace('_', ' ', ucfirst($order['payment_method'])); ?></span>
      </div>
      <div class="info-item">
        <span class="info-label">Customer Name</span>
        <span class="info-value"><?php echo $order['customer_name']; ?></span>
      </div>
      <div class="info-item">
        <span class="info-label">Email</span>
        <span class="info-value"><?php echo $order['customer_email']; ?></span>
      </div>
      <div class="info-item" style="grid-column: 1 / -1;">
        <span class="info-label">Shipping Address</span>
        <span class="info-value"><?php echo $order['shipping_address']; ?></span>
      </div>
      <?php if ($order['notes']): ?>
      <div class="info-item" style="grid-column: 1 / -1;">
        <span class="info-label">Order Notes</span>
        <span class="info-value"><?php echo $order['notes']; ?></span>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="info-card">
    <h3 class="card-title">🛍️ Order Items</h3>
    <?php foreach ($order_items as $item): ?>
    <div class="item-row">
      <img src="../../admin panel/assets/images/<?php echo $item['p_image']; ?>" alt="<?php echo $item['p_name']; ?>">
      <div class="item-info">
        <div class="item-name"><?php echo $item['p_name']; ?></div>
        <div class="item-meta"><?php echo $item['c_name']; ?> | Qty: <?php echo $item['quantity']; ?> | $<?php echo number_format($item['price'], 2); ?> each</div>
      </div>
      <div class="item-price">$<?php echo number_format($item['total'], 2); ?></div>
    </div>
    <?php endforeach; ?>
    <div class="totals-section">
      <div class="total-row">
        <span class="label">Subtotal</span>
        <span class="value">$<?php echo number_format($order['subtotal'], 2); ?></span>
      </div>
      <div class="total-row">
        <span class="label">Shipping</span>
        <span class="value" style="color: var(--success);">FREE</span>
      </div>
      <div class="total-row">
        <span class="label">Tax (5%)</span>
        <span class="value">$<?php echo number_format($order['tax'], 2); ?></span>
      </div>
      <div class="total-row grand">
        <span class="label">Total</span>
        <span class="value">$<?php echo number_format($order['total'], 2); ?></span>
      </div>
    </div>
  </div>
</div>
</body>

<script src="../assets/js/layout.js"></script>
</html>