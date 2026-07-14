<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="icon" type="image/x-icon" href="../assets/images/logo.jpg">
<title>Time Zone</title>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="../assets/css/style.css"/>
</head>
<body>
<div class="admin-wrapper">
<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-brand"><h2 style="font-weight: 900; font-size:24px;">Time Zone</h2><p>Luxury Management</p></div>
  <?php
// Ye line automatically detect karegi ke current page kitni deep hai
$base = str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 2);
?>

<nav class="sidebar-nav">
    <a href="/e-project/admin%20panel/pages/index.php" class="nav-link">
        <span class="material-symbols-outlined">dashboard</span>
        <span>Dashboard</span>
    </a>
    <a href="/e-project/admin%20panel/pages/CATEGORIES/" class="nav-link">
        <span class="material-symbols-outlined">category</span>
        <span>Categories</span>
    </a>
    <a href="/e-project/admin%20panel/pages/products/" class="nav-link">
        <span class="material-symbols-outlined">inventory_2</span>
        <span>Products</span>
    </a>
    <a href="/e-project/admin%20panel/pages/order.php" class="nav-link">
        <span class="material-symbols-outlined">shopping_cart</span>
        <span>Orders</span>
    </a>
    <a href="/e-project/admin%20panel/pages/user/employees.php" class="nav-link">
        <span class="material-symbols-outlined">badge</span>
        <span>User</span>
    </a>
    
    <a href="/e-project/admin%20panel/pages/feedbacks.php" class="nav-link">
        <span class="material-symbols-outlined">forum</span>
        <span>Feedback</span>
    </a>
</nav>
  <div class="sidebar-footer">
  <a href="/e-project/admin%20panel/pages/settings.php" class="nav-link"><span class="material-symbols-outlined">settings</span><span>Settings</span></a>
    <a href="../../../../e-project/user_panel/pages/login.php" class="nav-link logout"><span class="material-symbols-outlined">logout</span><span>Logout</span></a>
  </div>
</aside>
<!-- MAIN -->
<div class="main-content">
<header class="top-header">
  <div style="display:flex;align-items:center;gap:32px;">
    <span class="header-brand" style="font-weight: 900;">Time Zone</span>
    
  </div>
  <div class="header-right">
    <button class="notif-btn"><span class="material-symbols-outlined">notifications</span><span class="notif-dot"></span></button>
    <div class="admin-user">
      <div class="admin-user-info" style="text-align:right"><p>Admin User</p><span></span></div>
      <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDw73XO4P020_6hUjv0atY8oAp0GfrtL-Azzbo5ZP90C8GPBIfqUAY4ofOZzIen4GUeU3uAGZZ1lqm64PZPadg-WzLxpOHXMVijnrc46g6qxzmjirC_eganzaQi_jVnaxjMuQH58dk9VTw_dprMn6a7OBwkvRoWF7Yk2mIeFCCkWGE7GzS8IxgnIYVewsfgP3igSjPxE3imec7fAb38wO9wQBS0ClMEt5HGaoVdjKLoOBYvtju9AoFkFQAhGF_Tr29GcM_i4NbSNeo7" alt="Admin"/>
    </div>
  </div>
</header>
