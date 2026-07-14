<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Profile — TimeZone Watches</title>
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
    <h1 class="page-title">My <em>Profile</em></h1>
    <div class="breadcrumb">
      <a href="index.html">Home</a><span>/</span><span>Profile</span>
    </div>
  </div>
</div>

<div class="profile-wrap">
  <!-- SIDEBAR -->
  <aside class="profile-sidebar">
    <div class="profile-avatar" id="avatarEl">JD</div>
    <div class="profile-name" id="profileName">John Doe</div>
    <div class="profile-email" id="profileEmail">john@example.com</div>
    <div class="profile-level">◆ Gold Member</div>
    <ul class="sidebar-nav">
      <li><a href="profile.php" class="active"><span class="nav-icon">◈</span> My Profile</a></li>
      <li><a href="my_orders.php"><span class="nav-icon">◎</span> My Orders</a></li>
      <li><a href="cart.php"><span class="nav-icon">◇</span> My Cart</a></li>
      <li><a href="#"><span class="nav-icon">◉</span> Wishlist</a></li>
      <li><a href="#"><span class="nav-icon">○</span> Addresses</a></li>
      <li><a href="logout.php"><span class="nav-icon">✕</span> Logout</a></li>
    </ul>
  </aside>

  <!-- MAIN -->
  <div class="profile-main">
    <div class="stats-row">
      <div class="stat-card reveal">
        <div class="stat-num" id="orderCount">3</div>
        <div class="stat-label">Total Orders</div>
      </div>
      <div class="stat-card reveal" data-delay="100">
        <div class="stat-num">2</div>
        <div class="stat-label">Wishlist Items</div>
      </div>
      <div class="stat-card reveal" data-delay="200">
        <div class="stat-num">◆</div>
        <div class="stat-label">Member Status</div>
      </div>
    </div>

    <!-- PERSONAL INFO -->
    <div class="profile-section">
      <div class="ps-header">
        <div class="ps-title">Personal Information</div>
        <div class="ps-edit" onclick="toggleEdit()">Edit Profile</div>
      </div>
      <div id="profileForm">
        <div class="form-row-2">
          <div class="form-group">
            <label class="form-label">First Name</label>
            <input type="text" class="form-input" id="fName" value="John">
          </div>
          <div class="form-group">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-input" id="lName" value="Doe">
          </div>
        </div>
        <div class="form-row-2">
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-input" id="pEmail" value="john@example.com">
          </div>
          <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="tel" class="form-input" value="+1 (555) 000-0000">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Date of Birth</label>
          <input type="date" class="form-input" value="1990-06-15">
        </div>
        <button class="btn-primary" onclick="saveProfile()">Save Changes →</button>
      </div>
    </div>

    <!-- PREFERENCES -->
    <div class="profile-section">
      <div class="ps-header">
        <div class="ps-title">Notifications</div>
      </div>
      <div class="pref-row">
        <div>
          <div class="pref-label">Order Updates</div>
          <div class="pref-sub">Receive shipping & delivery notifications</div>
        </div>
        <div class="toggle on" onclick="this.classList.toggle('on')"></div>
      </div>
      <div class="pref-row">
        <div>
          <div class="pref-label">New Arrivals</div>
          <div class="pref-sub">Be first to know about new timepieces</div>
        </div>
        <div class="toggle on" onclick="this.classList.toggle('on')"></div>
      </div>
      <div class="pref-row">
        <div>
          <div class="pref-label">Exclusive Offers</div>
          <div class="pref-sub">Member-only discounts and promotions</div>
        </div>
        <div class="toggle" onclick="this.classList.toggle('on')"></div>
      </div>
      <div class="pref-row">
        <div>
          <div class="pref-label">Newsletter</div>
          <div class="pref-sub">Weekly watchmaking insights & stories</div>
        </div>
        <div class="toggle on" onclick="this.classList.toggle('on')"></div>
      </div>
    </div>

    
   
  </div>
</div>


<script src="../assets/js/layout.js"></script>
<script src="../assets/js/app.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const user = User.get();
  if (user) {
    const names = (user.name || '').split(' ');
    document.getElementById('profileName').textContent = user.name || 'Guest';
    document.getElementById('profileEmail').textContent = user.email || '';
    document.getElementById('avatarEl').textContent = (names[0]?.[0] || 'U') + (names[1]?.[0] || '');
    if (names[0]) document.getElementById('fName').value = names[0];
    if (names[1]) document.getElementById('lName').value = names[1];
    if (user.email) document.getElementById('pEmail').value = user.email;
  }
  const orders = JSON.parse(localStorage.getItem('tz_orders') || '[]');
  document.getElementById('orderCount').textContent = orders.length || 3;
});

function saveProfile() {
  const fn = document.getElementById('fName').value.trim();
  const ln = document.getElementById('lName').value.trim();
  const em = document.getElementById('pEmail').value.trim();
  User.set({ name: `${fn} ${ln}`, email: em });
  showToast('Profile updated successfully!');
  document.getElementById('profileName').textContent = `${fn} ${ln}`;
}

function toggleEdit() {
  const inputs = document.querySelectorAll('#profileForm .form-input');
  const isReadonly = inputs[0].readOnly;
  inputs.forEach(i => i.readOnly = !isReadonly);
  showToast(isReadonly ? 'Edit mode enabled' : 'Edit mode disabled');
}
</script>
</body>
</html>
