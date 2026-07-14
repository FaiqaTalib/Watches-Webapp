
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
?>
<link
  href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap"
  rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
  rel="stylesheet" />
<link rel="stylesheet" href="../assets/css/style.css" />
<script src="../assets/js/script.js"></script>



<?php
$query = 'SELECT * FROM feedback';
$res = mysqli_query($conn , $query);


$show_count_query = 'SELECT COUNT(*) AS total FROM feedback';
$c_res = mysqli_query($conn, $show_count_query);
$s_data = mysqli_fetch_assoc($c_res);
?>





<div class="page-content">
  <div class="page-header" style="flex-direction:column;align-items:flex-start;gap:8px;">
    <p style="color:var(--primary);font-size:0.75rem;text-transform:uppercase;letter-spacing:0.2em;">Customer Sentiment
    </p>
    <h2 class="font-serif">Client Feedback</h2>
  </div>
  <div class="stat-grid" style="grid-template-columns:repeat(2,1fr);" >
    <div class="stat-card">
      <p class="stat-label">Avg Rating</p>
      <h3 class="stat-value" style="color:var(--primary);">4.8 ★</h3>
    </div>
    <div class="stat-card">
      <p class="stat-label">Total Reviews</p>
      <h3 class="stat-value">
       <?php echo $s_data['total']; ?>
    </h3>
    </div>
  </div>

  <div style="display:flex;flex-direction:column;gap:16px;">
    <?php foreach($res as $data){ ?>
    <div style="background:var(--surface-container-low);border-radius:12px;padding:24px;">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
        <div style="display:flex;align-items:center;gap:12px;">
          <div class="avatar"><?php echo $data['name'][0] ?></div>
          <div>
            <p style="font-weight:600;font-size:0.875rem;"><?php echo $data['name'] ?></p>
            <p style="font-size:10px;color:var(--on-surface-variant);"> 2 days ago</p>
          </div>
        </div>
        <div style="color:var(--primary);"><?php echo $data['review'] ?></div>
      </div>
      <p style="font-size:0.875rem;color:rgba(208,197,181,0.8);line-height:1.7;margin-bottom:16px;">The <?php echo $data['mess'] ?></p>
     
    </div>
    <?php } ?>
   
  </div>
</div>
<div id="respond-modal" class="modal-backdrop" onclick="closeModalOnBackdrop(event,'respond-modal')">
  <div class="modal-box">
    <div class="modal-header">
      <div>
        <h2>Respond to Review</h2>
        <p>Official Atelier Response</p>
      </div><button class="close-btn" onclick="closeModal('respond-modal')"><span
          class="material-symbols-outlined">close</span></button>
    </div>
    <div class="modal-body">
      <form onsubmit="handleFormSubmit(event,'respond-modal','Response posted!')">
        <div style="display:flex;flex-direction:column;gap:20px;">
          <div style="background:var(--surface-container);padding:16px;border-radius:8px;">
            <p style="font-size:10px;text-transform:uppercase;color:var(--primary);margin-bottom:8px;">Original Review
            </p>
            <p style="font-size:0.875rem;color:var(--on-surface-variant);font-style:italic;">"The Patek Philippe arrived
              in immaculate condition..."</p>
          </div>
          <div class="form-group"><label class="form-label">Your Response</label><textarea name="response"
              class="form-textarea" rows="5" placeholder="Write a professional response on behalf of Luxrio Atelier..."
              required></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn-ghost"
            onclick="closeModal('respond-modal')">Cancel</button><button type="submit" class="btn-primary">Post
            Response</button></div>
      </form>
    </div>
  </div>
</div>
</div>
<script src="../assets/js/script.js"></script>
<script>(function () { var p = location.pathname.split('/').pop(); document.querySelectorAll('.nav-link[href]').forEach(function (l) { if (l.getAttribute('href') == p) l.classList.add('active'); }); })();</script>
<?php
include '../common/FOOTER.php';
?>