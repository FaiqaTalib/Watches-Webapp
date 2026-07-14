<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Orders — TimeZone Watches</title>
<link rel="stylesheet" href="../assets/css/style.css"/>

</head>

<?php 
session_start();
if($_SESSION['role']!='user'){
  header("location: login.php");
  exit();
}
?>
<body>

<div class="page-header">
  <div class="page-header-inner">
    <div class="page-badge">My Account</div>
    <h1 class="page-title">My <em>Orders</em></h1>
    <div class="breadcrumb">
      <a href="index.html">Home</a><span>/</span><span>Orders</span>
    </div>
  </div>
</div>

<div class="orders-wrap">
  <div id="ordersContainer"></div>
</div>

<script src="../assets/js/layout.js"></script>
<script src="../assets/js/app.js"></script>
<script>
function getStatusClass(s) {
  const map = { Processing: 'status-processing', Shipped: 'status-shipped', Delivered: 'status-delivered', Cancelled: 'status-cancelled' };
  return map[s] || 'status-processing';
}

function renderOrders() {
  const container = document.getElementById('ordersContainer');
  let orders = JSON.parse(localStorage.getItem('tz_orders') || '[]');

  // Add demo orders if empty
  if (!orders.length) {
    orders = [
      {
        id: 'TZ1000001', date: 'June 12, 2025',
        items: [{ brand: 'Omega', name: 'Seamaster Professional', price: 5890, qty: 1, image: 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=200&h=200&fit=crop' }],
        total: 6361.2, status: 'Delivered'
      },
      {
        id: 'TZ1000002', date: 'July 3, 2025',
        items: [{ brand: 'Cartier', name: 'Tank Must', price: 3200, qty: 1, image: 'https://images.unsplash.com/photo-1493051433-8e08a6b1d2b3?w=200&h=200&fit=crop' }],
        total: 3456, status: 'Shipped'
      },
      {
        id: 'TZ1000003', date: 'August 20, 2025',
        items: [
          { brand: 'Rolex', name: 'Datejust 41', price: 8900, qty: 1, image: 'https://images.unsplash.com/photo-1619134778706-7015533a6150?w=200&h=200&fit=crop' },
          { brand: 'IWC', name: 'Big Pilot 43', price: 8200, qty: 1, image: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=200&h=200&fit=crop' }
        ],
        total: 18468, status: 'Processing'
      }
    ];
  }

  if (!orders.length) {
    container.innerHTML = `
      <div class="empty-orders">
        <h3>No Orders Yet</h3>
        <p>Your luxury timepiece journey awaits.</p>
        <a href="products.html" class="btn-primary">Explore Collection →</a>
      </div>`;
    return;
  }

  container.innerHTML = orders.map(order => `
    <div class="order-card reveal">
      <div class="order-header">
        <div>
          <div style="font-size:9px;color:var(--gray);letter-spacing:2px;text-transform:uppercase;margin-bottom:4px;">Order ID</div>
          <div class="order-id">#${order.id}</div>
        </div>
        <div class="order-date">${order.date}</div>
        <div class="order-status ${getStatusClass(order.status)}">${order.status}</div>
      </div>
      <div class="order-items">
        ${order.items.map(item => `
          <div class="order-item">
            <div class="order-item-img">
              <img src="${item.image}" alt="${item.name}">
            </div>
            <div>
              <div class="order-item-brand">${item.brand}</div>
              <div class="order-item-name">${item.name}</div>
              <div class="order-item-qty">Qty: ${item.qty}</div>
            </div>
            <div class="order-item-price">${formatPrice(item.price * item.qty)}</div>
          </div>`).join('')}
      </div>
      <div class="order-footer">
        <div>
          <div class="order-total-label">Order Total</div>
          <div class="order-total">${formatPrice(order.total)}</div>
        </div>
        <div class="order-actions">
          <button class="order-btn order-btn-outline">Track Order</button>
          <button class="order-btn order-btn-primary">Reorder</button>
        </div>
      </div>
    </div>`).join('');

  initScrollReveal();
}

document.addEventListener('DOMContentLoaded', renderOrders);
</script>
</body>
</html>
