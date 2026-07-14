<?php 
include '../common/header.php';
include('../config/conn.php');
?>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="../assets/css/style.css"/>
<script src="../assets/js/script.js"></script>



<?php 
session_start();

if($_SESSION['role']!='admin'){
  header("location: ../../../../e-project/user_panel/pages/login.php");
  exit();
}
?>
<?php
$query = "SELECT * FROM users WHERE role = 'admin'";
$res = mysqli_query($conn , $query);
$data = mysqli_fetch_assoc($res);





?>


<div class="page-content">
  <div style="max-width:1024px;margin:0 auto;">
    <div style="margin-bottom:40px;"><h2 class="font-serif" style="font-size:3rem;">Admin profile</h2><p style="color:var(--primary);text-transform:uppercase;letter-spacing:0.2em;font-size:0.7rem;font-weight:600;margin-top:8px;">Configuration Panel</p></div>
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:32px;margin-bottom:32px;">


    
      <!-- Profile -->
      <div style="background:var(--surface-container-low);border-radius:12px;padding:32px; width: 75vw;">
        <h3 class="font-serif" style="font-size:1.25rem;margin-bottom:24px;">Profile Information</h3>
        <div style="display:flex;align-items:center;gap:24px;padding-bottom:24px;border-bottom:1px solid rgba(255,255,255,0.05);margin-bottom:24px;">
          <div style="position:relative;">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDw73XO4P020_6hUjv0atY8oAp0GfrtL-Azzbo5ZP90C8GPBIfqUAY4ofOZzIen4GUeU3uAGZZ1lqm64PZPadg-WzLxpOHXMVijnrc46g6qxzmjirC_eganzaQi_jVnaxjMuQH58dk9VTw_dprMn6a7OBwkvRoWF7Yk2mIeFCCkWGE7GzS8IxgnIYVewsfgP3igSjPxE3imec7fAb38wO9wQBS0ClMEt5HGaoVdjKLoOBYvtju9AoFkFQAhGF_Tr29GcM_i4NbSNeo7" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid rgba(230,196,135,0.3);" alt="Admin"/>
            <!-- <button onclick="document.getElementById('av').click()" style="position:absolute;bottom:0;right:0;background:var(--primary);color:var(--on-primary);border:none;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;cursor:pointer;"><span class="material-symbols-outlined" style="font-size:14px;">photo_camera</span></button> -->
            <input type="file" id="av" accept="image/*" style="display:none;"/>
          </div>
          <div><p style="font-weight:600;font-size:1.125rem;"><?php echo $data['username'] ?></p><p style="font-size:0.75rem;color:var(--on-surface-variant);"><?php echo $data['role'] ?></p><p style="font-size:0.75rem;color:var(--primary);margin-top:4px;"><?php echo $data['email'] ?></p></div>
        </div>
        <form onsubmit="event.preventDefault();showToast('Profile saved!')">
          <div style="display:flex;flex-direction:column;gap:20px;">
            <div class="form-group"><label class="form-label">Full Name</label><input type="text" name="name" class="form-input" value="<?php echo $data['username'] ?>" style="font-size:1.125rem;font-weight:300;"/></div>
            <div class="form-group"><label class="form-label">Email Address</label><input type="email" name="email" class="form-input" value="<?php echo $data['email'] ?>"/></div>
            <div class="form-group"><label class="form-label">Role Title</label><input type="text" name="role" class="form-input" value="<?php echo $data['role'] ?>"/></div>
          </div>
          <!-- <div style="margin-top:24px;"><button type="submit" class="btn-primary">Save Profile</button></div> -->
        </form>
      </div>
      
    </div>
    <!-- System Config -->
   
  </div>
</div>
</div>
<?php
include '../common/FOOTER.php';
?>