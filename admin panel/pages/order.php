
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
    header('Location: order.php');
    exit;
}

$orders_query = "SELECT * FROM orders ORDER BY created_at DESC";
$orders_result = mysqli_query($conn, $orders_query);
$orders = [];
while ($row = mysqli_fetch_assoc($orders_result)) {
    $orders[] = $row;
}

$stats_query = "SELECT COUNT(*) as total, SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending, SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing, SUM(CASE WHEN status = 'shipped' THEN 1 ELSE 0 END) as shipped, SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as delivered, SUM(total) as revenue FROM orders";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Orders Management — Admin Panel</title>
<link
  href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap"
  rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
  rel="stylesheet" />
<link rel="stylesheet" href="../assets/css/style.css" />
<script src="../assets/js/script.js"></script>
<style>/* ===== ADMIN DASHBOARD (ALIGNED WITH MOTHER CSS) ===== */

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

/* Sidebar (use existing style, no heavy override) */


/* Main */
.main-content-order {
  flex: 1;
  margin: 20px;
 
}

/* Header */
.page-header-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 32px;
}

.page-title {
  font-family: 'Noto Serif', serif;
  font-size: 2rem;
  font-weight: 400;
  letter-spacing: -0.02em;
}

/* Stats */
.stats-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
  gap: 24px;
  margin-bottom: 40px;
}

.stat-box {
  background: var(--surface-container-low);
  padding: 24px;
  border-radius: 12px;
  border-bottom: 2px solid transparent;
  transition: all 0.3s;
}

.stat-box:hover {
  border-bottom-color: var(--primary);
}

.stat-box .number {
  font-family: 'Noto Serif', serif;
  font-size: 1.75rem;
}

.stat-box .label {
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  color: var(--outline);
}

/* Colors mapped to system */
.stat-box.total-revenue .number { color: var(--primary); }
.stat-box.pending .number { color: var(--outline); }
.stat-box.processing .number { color: var(--primary-container); }
.stat-box.shipped .number { color: var(--outline-variant); }
.stat-box.delivered .number { color: var(--primary); }

/* Table */
.table-card {
  background: var(--surface-container-low);
  border-radius: 12px;
  overflow: hidden;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.875rem;
}

.data-table th {
  padding: 16px 24px;
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: var(--outline);
  background: rgba(32,31,32,0.5);
  border-bottom: 1px solid rgba(255,255,255,0.05);
}

.data-table td {
  padding: 18px 24px;
  border-bottom: 1px solid rgba(77,70,58,0.15);
}

.data-table tr:hover {
  background: rgba(255,255,255,0.03);
}

/* Order */
.order-num {
  font-weight: 700;
  color: var(--primary);
}

/* Customer */
.customer-name {
  font-weight: 600;
}

.customer-email {
  font-size: 0.75rem;
  color: var(--outline);
}

/* Status Select */
.status-select {
  padding: 6px 12px;
  background: var(--surface-container-low);
  border: 1px solid rgba(77,70,58,0.3);
  color: var(--on-surface);
  border-radius: 6px;
  font-size: 0.8rem;
}

.status-select:focus {
  border-color: var(--primary);
  outline: none;
}

/* Amount */
.amount {
  font-weight: 600;
}

/* Buttons */
.action-btns {
  display: flex;
  gap: 8px;
}

/* use existing button style instead */
.btn-view {
  padding: 6px 12px;
  font-size: 0.75rem;
  border-radius: 6px;
  border: 1px solid rgba(77,70,58,0.3);
  color: var(--on-surface);
  transition: all 0.3s;
}

.btn-view:hover {
  border-color: var(--primary);
  color: var(--primary);
}

/* Responsive */
@media (max-width: 1024px) {
  .sidebar { width: 200px; }
  .main-content-order { margin-left: 200px; }
}

@media (max-width: 768px) {
  .sidebar { display: none; }
  .main-content-order { margin-left: 0; }
}</style>
</head>
<body>
<div class="admin-layout">
 
  <main class="main-content-order">
    <div class="page-header-bar">
      <h1 class="page-title">Orders Management</h1>
    </div>
    <div class="stats-row">
      <div class="stat-box total-revenue">
        <div class="number">$<?php echo number_format($stats['revenue'] ?? 0, 0); ?></div>
        <div class="label">Total Revenue</div>
      </div>
      <div class="stat-box pending">
        <div class="number"><?php echo $stats['pending'] ?? 0; ?></div>
        <div class="label">Pending</div>
      </div>
      <div class="stat-box processing">
        <div class="number"><?php echo $stats['processing'] ?? 0; ?></div>
        <div class="label">Processing</div>
      </div>
      <div class="stat-box shipped">
        <div class="number"><?php echo $stats['shipped'] ?? 0; ?></div>
        <div class="label">Shipped</div>
      </div>
      <div class="stat-box delivered">
        <div class="number"><?php echo $stats['delivered'] ?? 0; ?></div>
        <div class="label">Delivered</div>
      </div>
    </div>
    <div class="table-card">
      <table class="data-table">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th class="hide-sm">Date</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $order): ?>
          <tr>
            <td><span class="order-num"><?php echo $order['order_number']; ?></span></td>
            <td>
              <div class="customer-info">
                <span class="customer-name"><?php echo $order['customer_name']; ?></span>
                <span class="customer-email"><?php echo $order['customer_email']; ?></span>
              </div>
            </td>
            <td class="hide-sm"><?php echo date('M j, Y g:i A', strtotime($order['created_at'])); ?></td>
            <td class="amount">$<?php echo number_format($order['total'], 2); ?></td>
            <td><?php echo str_replace('_', ' ', ucfirst($order['payment_method'])); ?></td>
            <td>
              <form method="POST" style="display: inline;">
                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                <select name="status" class="status-select" onchange="this.form.submit()">
                  <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                  <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                  <option value="shipped" <?php echo $order['status'] == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                  <option value="delivered" <?php echo $order['status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                  <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
                <input type="hidden" name="update_status" value="1">
              </form>
            </td>
            <td>
              <div class="action-btns">
                <a href="order_detail.php?id=<?php echo $order['order_id']; ?>" class="btn-sm btn-view">View</a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
</body>
</html>