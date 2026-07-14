
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

$orders_query = "SELECT * FROM orders ORDER BY created_at DESC";
$orders_result = mysqli_query($admin, $orders_query);

$orders = [];
while ($row = mysqli_fetch_assoc($orders_result)) {
    $orders[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Orders — TimeZone Watches</title>
<link rel="stylesheet" href="../assets/css/style.css"/>
<style>
  /* ===== ORDERS PAGE (ALIGNED WITH MOTHER CSS) ===== */

body {
  background: var(--black);
  color: var(--white);
  font-family: var(--font-body);
}

/* Header */
.page-header {
  background: var(--dark);
  border-bottom: 1px solid var(--border);
  padding: 30px 0;
}

.header-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

/* Title */
.page-title {
  font-family: var(--font-display);
  font-size: 42px;
  font-weight: 400;
  margin-bottom: 8px;
  letter-spacing: 2px;
  color: var(--white);
}

/* Breadcrumb */
.breadcrumb {
  color: var(--gray);
  font-size: 11px;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.breadcrumb a {
  color: var(--gold);
}

/* Container */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 20px;
}

/* Stats */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 2px;
  margin-bottom: 40px;
}

.stat-card {
  background: var(--dark-2);
  padding: 28px;
  border: 1px solid var(--border);
  transition: var(--transition);
}

.stat-card:hover {
  border-color: var(--border-gold);
}

.stat-value {
  font-family: var(--font-display);
  font-size: 32px;
  color: var(--gold);
  margin-bottom: 6px;
}

.stat-label {
  color: var(--gray);
  font-size: 11px;
  letter-spacing: 2px;
  text-transform: uppercase;
}

/* Orders Card */
.orders-card {
  background: var(--dark-2);
  border: 1px solid var(--border);
}

/* Header */
.card-header {
  padding: 20px 24px;
  border-bottom: 1px solid var(--border);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-title {
  font-family: var(--font-display);
  font-size: 20px;
  font-weight: 400;
}

/* Table */
.orders-table {
  width: 100%;
  border-collapse: collapse;
}

.orders-table th {
  text-align: left;
  padding: 14px 20px;
  color: var(--gray);
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 2px;
  border-bottom: 1px solid var(--border);
}

.orders-table td {
  padding: 18px 20px;
  border-bottom: 1px solid var(--border);
  font-size: 13px;
}

.orders-table tr:hover {
  background: rgba(255,255,255,0.02);
}

/* Order ID */
.order-id {
  font-weight: 600;
  color: var(--gold);
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

/* Button */
.view-btn {
  padding: 8px 16px;
  background: transparent;
  border: 1px solid var(--border);
  color: var(--white);
  border-radius: 1px;
  font-size: 10px;
  letter-spacing: 2px;
  text-transform: uppercase;
  transition: var(--transition);
  display: inline-block;
}

.view-btn:hover {
  border-color: var(--gold);
  color: var(--gold);
}

/* Price */
.price {
  font-weight: 600;
  color: var(--white);
}

/* Empty */
.empty-orders {
  text-align: center;
  padding: 80px 20px;
}

.empty-title {
  font-family: var(--font-display);
  font-size: 32px;
  margin-bottom: 10px;
}

.empty-text {
  color: var(--gray);
  margin-bottom: 30px;
}

/* Use system button */
.shop-btn {
  display: inline-block;
}

/* Responsive */
@media (max-width: 768px) {
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
  .orders-table th, .orders-table td { padding: 12px 16px; }
  .hide-mobile { display: none; }
}
</style>
</head>
<body>
<div class="page-header">
  <div class="header-inner">
    <h1 class="page-title">My Orders</h1>
    <div class="breadcrumb">
 
    </div>
  <div class="header-inner">
    <h1 class="page-title">My Orders</h1>
    <div class="breadcrumb">
      <a href="index.php">Home</a> / <span>My Orders</span>
    </div>
  </div>
</div>
<div class="container">
  <?php if (empty($orders)): ?>
    <div class="empty-orders">
      <div class="empty-icon">📦</div>
      <h2 class="empty-title">No Orders Yet</h2>
      <p class="empty-text">You haven't placed any orders yet. Start exploring our collection!</p>
      <a href="products.php" class="shop-btn">Start Shopping</a>
    </div>
  <?php else: ?>
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-value"><?php echo count($orders); ?></div>
        <div class="stat-label">Total Orders</div>
      </div>
      <div class="stat-card">
        <div class="stat-value"><?php echo count(array_filter($orders, fn($o) => $o['status'] == 'pending')); ?></div>
        <div class="stat-label">Pending</div>
      </div>
      <div class="stat-card">
        <div class="stat-value"><?php echo count(array_filter($orders, fn($o) => $o['status'] == 'delivered')); ?></div>
        <div class="stat-label">Delivered</div>
      </div>
      <div class="stat-card">
        <div class="stat-value">$<?php echo number_format(array_sum(array_column($orders, 'total')), 0); ?></div>
        <div class="stat-label">Total Spent</div>
      </div>
    </div>
    <div class="orders-card">
      <div class="card-header">
        <h3 class="card-title">Order History</h3>
      </div>
      <table class="orders-table">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Date</th>
            <th class="hide-mobile">Items</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $order): 
            $items_count_query = "SELECT COUNT(*) as count FROM order_items WHERE order_id = " . $order['order_id'];
            $items_count_result = mysqli_query($admin, $items_count_query);
            $items_count = mysqli_fetch_assoc($items_count_result)['count'];
          ?>
          <tr>
            <td><span class="order-id"><?php echo $order['order_number']; ?></span></td>
            <td><?php echo date('M j, Y', strtotime($order['created_at'])); ?></td>
            <td class="hide-mobile"><?php echo $items_count; ?> item(s)</td>
            <td class="price">$<?php echo number_format($order['total'], 2); ?></td>
            <td><span class="status-badge status-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span></td>
            <td><a href="order_details.php?id=<?php echo $order['order_id']; ?>" class="view-btn">View Details</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<script src="../assets/js/layout.js"></script>
</body>
</html>