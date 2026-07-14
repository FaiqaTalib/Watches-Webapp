<!-- common links -->

<?php 
session_start();
if($_SESSION['role']!='admin'){
  header("location: ../../../../e-project/user_panel/pages/login.php");
  exit();
}
?>
<?php 
include '../common/header.php';
?>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="../assets/css/style.css"/>
<script src="../assets/js/script.js"></script>


<?php
include('../config/conn.php');

$salesLabels = [];
$orderData = [];
$revenueData = [];

$sales_query = "
    SELECT 
        DATE(created_at) AS sale_date,
        COUNT(order_id) AS total_orders,
        SUM(total) AS total_revenue
    FROM orders
    GROUP BY DATE(created_at)
    ORDER BY sale_date ASC
";

$sales_result = mysqli_query($conn, $sales_query);

if ($sales_result) {
    while ($row = mysqli_fetch_assoc($sales_result)) {
        $salesLabels[] = $row['sale_date'];
        $orderData[] = (int)$row['total_orders'];
        $revenueData[] = (float)$row['total_revenue'];
    }
}





// order 
$orders_query = "SELECT * FROM orders ORDER BY created_at DESC";
$orders_result = mysqli_query($conn, $orders_query);
$orders = [];
while ($row = mysqli_fetch_assoc($orders_result)) {
    $orders[] = $row;
}



// total



// Orders Count
$sql_orders_count = "SELECT COUNT(*) AS total_orders FROM orders";
$res_orders_count = mysqli_query($conn, $sql_orders_count);
$row_orders_count = mysqli_fetch_assoc($res_orders_count);

// Revenue Sum
$sql_revenue_sum = "SELECT SUM(total) AS total_revenue FROM orders";
$res_revenue_sum = mysqli_query($conn, $sql_revenue_sum);
$row_revenue_sum = mysqli_fetch_assoc($res_revenue_sum);

// Products Count
$sql_products_count = "SELECT COUNT(*) AS total_products FROM products";
$res_products_count = mysqli_query($conn, $sql_products_count);
$row_products_count = mysqli_fetch_assoc($res_products_count);

// Customers Count
$sql_customers_count = "SELECT COUNT(*) AS total_customers FROM users WHERE role='user'";
$res_customers_count = mysqli_query($conn, $sql_customers_count);
$row_customers_count = mysqli_fetch_assoc($res_customers_count);


?>



<!-- html start -->
<div class="page-content">
  <!-- Header -->
  <div class="page-header">
    <div class="page-title">
      <h2 class="font-serif">Atelier Overview</h2>
      <p style="color:var(--primary);text-transform:uppercase;letter-spacing:0.15em;font-size:0.75rem;font-weight:600;margin-top:8px;">Performance &amp; Curation Metrics</p>
    </div>
    <div style="display:flex;gap:12px;">
      <button class="btn-secondary"><span class="material-symbols-outlined">calendar_today</span><span>Aug 01 – Aug 31, 2024</span></button>
      <button class="btn-primary" onclick="showToast('Report exported!')"><span class="material-symbols-outlined">file_download</span><span>Export Report</span></button>
    </div>
  </div>

  <!-- Stat Cards -->
<div class="stat-grid">

  <div class="stat-card">
    <p class="stat-label">Total Orders</p>
    <h3 class="stat-value"><?php echo $row_orders_count['total_orders']; ?></h3>
  </div>

  <div class="stat-card">
    <p class="stat-label">Total Revenue</p>
    <h3 class="stat-value">
      $<?php echo number_format($row_revenue_sum['total_revenue'], 2); ?>
    </h3>
  </div>

  <div class="stat-card">
    <p class="stat-label">Total Products</p>
    <h3 class="stat-value"><?php echo $row_products_count['total_products']; ?></h3>
  </div>

  <div class="stat-card">
    <p class="stat-label">Total Customers</p>
    <h3 class="stat-value"><?php echo $row_customers_count['total_customers']; ?></h3>
  </div>

</div>

  <!-- Charts -->
  <div style="display:grid;grid-template-columns:1fr;gap:24px;margin-bottom:40px; height: 400px;">

    <div class="chart-card" >
      <div style="margin-bottom:24px;"><h4>Order Volume</h4><p>Distribution by category</p></div>
      <div style="height: 300px;">
       <canvas id="myChart" ></canvas>
      </div>
    </div>
  </div>

  <!-- Recent Orders Table -->




<!-- Order Detail Modal -->
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const labels = <?php echo json_encode($salesLabels); ?>;
    const orderData = <?php echo json_encode($orderData); ?>;
    const revenueData = <?php echo json_encode($revenueData); ?>;

    const chartCanvas = document.getElementById('myChart');

    if (chartCanvas) {
        new Chart(chartCanvas, {
            data: {
                labels: labels,
                datasets: [
                  
                    {
                        type: 'bar',
                        label: 'Revenue',
                        data: revenueData,
                        borderColor: '#E6C487',
                        backgroundColor: 'rgba(230, 196, 135, 0.15)',
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#E6C487',
                        pointBorderWidth: 3,
                        borderWidth: 3,
                        tension: 0,
                        fill: false,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#E6C487'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.dataset.label === 'Revenue') {
                                    return 'Revenue: Rs ' + context.parsed.y;
                                }
                                return 'Orders: ' + context.parsed.y;
                            }
                        }
                    }
                },

                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date',
                            color: '#998F81'
                        },
                        ticks: {
                            color: '#998F81'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.05)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Orders',
                            color: '#998F81'
                        },
                        ticks: {
                            precision: 0,
                            color: '#998F81'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.05)'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Revenue',
                            color: '#998F81'
                        },
                        ticks: {
                            color: '#998F81'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
    }
});
</script>
<?php

include '../common/FOOTER.php';
?>