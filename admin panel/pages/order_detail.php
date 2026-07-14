
<?php 
session_start();

if($_SESSION['role']!='admin'){
  header("location: ../../../../e-project/user_panel/pages/login.php");
  exit();
}
?>
<?php
include '../common/header.php';
include('../config/conn.php');

// Handle status update
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE orders SET status = '$new_status' WHERE order_id = $order_id");
    header('Location: order_detail.php?id=' . $order_id);
    exit;
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($order_id <= 0) {
    header('Location: order.php');
    exit;
}

// Fetch order
$order_query = "SELECT * FROM orders WHERE order_id = $order_id";
$order_result = mysqli_query($conn, $order_query);
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    header('Location: order.php');
    exit;
}

// Fetch order items
$items_query = "SELECT oi.*, p.p_name, p.p_image, p.p_desc, cat.c_name 
                FROM order_items oi 
                JOIN products p ON oi.  product_id = p.p_id 
                JOIN category cat ON p.p_cid = cat.c_id 
                WHERE oi.order_id = $order_id";
$items_result = mysqli_query($conn, $items_query);

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
<title>Order #<?php echo $order['order_number']; ?> — Admin</title>
<style>/* ===== ADMIN ORDER DETAIL (ALIGNED WITH MOTHER CSS) ===== */

body {
  background: var(--background);
  color: var(--on-surface);
  font-family: 'Inter', sans-serif;
}

/* Layout */
.admin-layout {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 256px;
}

.main-content-order {
  flex: 1;
  /* margin-left: 256px; */
  padding: 32px;
}


/* Back Button */
.back-btn {
  padding: 8px 16px;
  margin: 32px;
  margin-bottom: 32px;
  background: var(--surface-container-low);
  border: 1px solid rgba(77,70,58,0.3);
  color: var(--on-surface-variant);
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s;
}

.back-btn:hover {
  border-color: var(--primary);
  color: var(--primary);
}

/* Status Badge */
.status-badge-lg {
  padding: 6px 14px;
  border-radius: 9999px;
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}

.status-pending {
  background: rgba(230,196,135,0.1);
  color: var(--primary);
}

.status-processing {
  background: rgba(234,179,8,0.1);
  color: #facc15;
}

.status-shipped {
  background: rgba(96,165,250,0.1);
  color: #60a5fa;
}

.status-delivered {
  background: rgba(34,197,94,0.1);
  color: #4ade80;
}

.status-cancelled {
  background: rgba(239,68,68,0.1);
  color: #f87171;
}

/* Cards */
.info-card {
  background: var(--surface-container-low);
  border-radius: 12px;
  padding: 28px;
  margin-bottom: 24px;
}

.card-title {
  font-family: 'Noto Serif', serif;
  font-size: 1.25rem;
  margin-bottom: 16px;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  padding-bottom: 10px;
}

/* Info */
.info-grid {
  display: grid;
  grid-template-columns: repeat(2,1fr);
  gap: 16px;
}

.info-label {
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  color: var(--outline);
}

.info-value {
  font-size: 0.875rem;
}

/* Status Update */
.status-update {
  background: var(--surface-container);
  border-radius: 12px;
  padding: 20px;
  margin-top: 20px;
}

.status-update-title {
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  color: var(--outline);
  margin-bottom: 10px;
}

.status-form {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.status-select {
  padding: 8px 14px;
  background: var(--surface-container-low);
  border: 1px solid rgba(77,70,58,0.3);
  border-radius: 6px;
  color: var(--on-surface);
}

.status-select:focus {
  border-color: var(--primary);
  outline: none;
}

/* Use system button */
.update-btn {
  padding: 10px 20px;
  background: var(--primary);
  color: var(--on-primary);
  border-radius: 6px;
  font-size: 0.8rem;
  font-weight: 600;
  cursor: pointer;
  border: none;
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
  background: rgba(77,70,58,0.3);
}

.timeline-step {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.step-dot {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  border: 1px solid var(--outline-variant);
  background: var(--background);
}

.step-dot.active {
  background: var(--primary);
}

.step-dot.completed {
  background: var(--primary);
}

.step-label {
  font-size: 10px;
  color: var(--outline);
}

/* Items */
.item-row {
  display: flex;
  gap: 14px;
  padding: 14px 0;
  border-bottom: 1px solid rgba(77,70,58,0.2);
}

.item-row img {
  width: 70px;
  height: 70px;
  object-fit: cover;
}

.item-name {
  font-size: 0.875rem;
}

.item-meta {
  font-size: 0.75rem;
  color: var(--outline);
}

.item-price {
  font-weight: 600;
  color: var(--primary);
}

/* Totals */
.totals-section {
  margin-top: 20px;
  border-top: 1px solid rgba(77,70,58,0.3);
  padding-top: 16px;
}

.total-row {
  display: flex;
  justify-content: space-between;
  font-size: 0.875rem;
}

.total-row.grand {
  font-weight: 700;
}

.total-row.grand .value {
  color: var(--primary);
}

/* Print */
.print-btn {
  padding: 8px 16px;
  border: 1px solid rgba(77,70,58,0.3);
  border-radius: 6px;
  font-size: 0.8rem;
  background: none;
  color: var(--on-surface);
}

.print-btn:hover {
  border-color: var(--primary);
  color: var(--primary);
}

/* Responsive */
@media (max-width: 768px) {
  .sidebar { display: none; }
  .main-content-order { margin-left: 0; }
  .info-grid { grid-template-columns: 1fr; }
  .timeline { flex-direction: column; gap: 16px; }
  .timeline::before { display: none; }
}</style>
</head>
<body>
<div class="admin-layout">
  
  <main class="main-content-order">
    <div class="page-header-bar">
      <div>
        <a href="order.php" class="back-btn">← Back to Orders</a>
        <br>
        <h1 class="page-title">Order <span>#<?php echo $order['order_number']; ?></span></h1>
      </div>
      <div style="display: flex; gap: 12px;">
        <span class="status-badge-lg status-<?php echo $order['status']; ?>">
          <?php echo ucfirst($order['status']); ?>
        </span>
        <button onclick="window.print()" class="print-btn">🖨️ Print</button>
      </div>
    </div>
    
    <!-- Status Update -->
    <div class="status-update">
      <div class="status-update-title">Update Order Status</div>
      <form method="POST" class="status-form">
        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
        <select name="status" class="status-select">
          <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>⏳ Pending</option>
          <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>⚙️ Processing</option>
          <option value="shipped" <?php echo $order['status'] == 'shipped' ? 'selected' : ''; ?>>🚚 Shipped</option>
          <option value="delivered" <?php echo $order['status'] == 'delivered' ? 'selected' : ''; ?>>✅ Delivered</option>
          <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>❌ Cancelled</option>
        </select>
        <button type="submit" name="update_status" class="update-btn">Update Status</button>
      </form>
    </div>
    
    <!-- Order Timeline -->
    <div class="info-card" style="margin-top: 24px;">
      <h3 class="card-title">📍 Order Timeline</h3>
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
    
    <!-- Customer Info -->
    <div class="info-card">
      <h3 class="card-title">👤 Customer Information</h3>
      <div class="info-grid">
        <div class="info-item">
          <span class="info-label">Full Name</span>
          <span class="info-value"><?php echo $order['customer_name']; ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Email</span>
          <span class="info-value"><?php echo $order['customer_email']; ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Phone</span>
          <span class="info-value"><?php echo $order['customer_phone']; ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Order Date</span>
          <span class="info-value"><?php echo date('F j, Y \a\t g:i A', strtotime($order['created_at'])); ?></span>
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
    
    <!-- Payment Info -->
    <div class="info-card">
      <h3 class="card-title">💳 Payment Information</h3>
      <div class="info-grid">
        <div class="info-item">
          <span class="info-label">Payment Method</span>
          <span class="info-value"><?php echo str_replace('_', ' ', ucfirst($order['payment_method'])); ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Order Status</span>
          <span class="info-value"><span class="status-badge-lg status-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span></span>
        </div>
        <div class="info-item">
          <span class="info-label">Order Number</span>
          <span class="info-value" style="color: var(--gold); font-weight: 700;"><?php echo $order['order_number']; ?></span>
        </div>
        <div class="info-item">
          <span class="info-label">Last Updated</span>
          <span class="info-value"><?php echo date('F j, Y g:i A', strtotime($order['updated_at'])); ?></span>
        </div>
      </div>
    </div>
    
    <!-- Order Items -->
    <div class="info-card">
      <h3 class="card-title">🛍️ Order Items (<?php echo count($order_items); ?>)</h3>
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
          <span class="label">Grand Total</span>
          <span class="value">$<?php echo number_format($order['total'], 2); ?></span>
        </div>
      </div>
    </div>
    
  </main>
</div>
</body>
</html>