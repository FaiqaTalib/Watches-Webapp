
<?php 
session_start();

if($_SESSION['role']!='admin'){
  header("location: ../../../user_panel/pages/login.php");
  exit();
}
?>
<?php 

// use LDAP\Result;
include '../../common/header.php';
?>
<link
  href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap"
  rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
  rel="stylesheet" />
<link rel="stylesheet" href="../../assets/css/style.css">
<script src="../../assets/js/script.js"></script>
<?php 
//  include('update.php');
include('../../config/conn.php');

$query="SELECT p.p_id , p.p_name , p.p_desc, p.p_price, p.p_stock, p.p_status ,p.p_image , c.c_name from products p join category c on p.p_cid = c.c_id";
$result=mysqli_query($conn,$query);
 ?>



<div class="page-content">
  <div class="page-header">
    <div class="page-title">
      <h2 class="font-serif">Product Management</h2>
      <p>Inventory &bull; Curated Collection</p>
    </div>
    <a href="add-product.php">
    <button class="btn-primary">
      <span class="material-symbols-outlined">add</span>Add Product
    </button>
    </a>
  </div>
  
  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Item</th>
          <!-- <th>Category</th> -->
          <th>Price</th>
          <th>Descripation</th>
          <th>Stock</th>
          <th>Status</th>
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($result as $data){ ?>
        <tr>
          <td style="font-family:monospace;font-size:0.75rem;color:var(--on-surface-variant);"><?php echo $data['p_id'] ?></td>
          <td>
            <div style="display:flex;align-items:center;gap:16px;">
              <div class="product-thumb"><img
                  src="../../assets/images/<?php echo $data['p_image'] ?>"
                  alt="" /></div>
              <div>
                <p style="font-weight:700;"><?php echo $data['p_name'] ?></p>
                <p style="font-size:0.75rem;color:var(--on-surface-variant);"><?php echo $data['c_name'] ?></p>
              </div>
            </div>
          <td style="font-weight:600;"><?php echo $data['p_price'] ?></td>
          <td style="font-family:monospace;font-size:0.75rem;color:var(--on-surface-variant); "><?php echo $data['p_desc'] ?></td>
          <td>
            <div style="display:flex;align-items:center;gap:8px;">
              <div style="width:6px;height:6px;border-radius:50%;background:var(--primary);"></div><span><?php echo $data['p_stock'] ?></span>
            </div>
          </td>
          <td><span class="badge badge-green"><?php echo $data['p_status'] ?></span></td>
          <td style="text-align:right;">
            <a href="update.php?id=<?php echo $data['p_id']?>">
                  <button class="btn-icon" onclick="openEditCategory()">
                    <span class="material-symbols-outlined">edit</span>
                  </button>
                </a>
                <a href="delete.php?id=<?php echo $data['p_id']?>">
                <button class="btn-icon danger" onclick="openDeleteModal()">
                      <span class="material-symbols-outlined">delete</span>
                    </button>
                  </a>
          </td>
        </tr>
<?php } ?>
      </tbody>
    </table>
    <div class="table-pagination">
      <p>Showing <strong>2</strong> of <strong>452</strong> products</p>
      <div class="pagination-btns"><button class="page-btn active">1</button><button class="page-btn">2</button><button
          class="page-btn">3</button></div>
    </div>
  </div>
</div>


<!-- EDIT PRODUCT MODAL -->
<div id="edit-product-modal" class="modal-backdrop" onclick="closeModalOnBackdrop(event,'edit-product-modal')">
  <div class="modal-box wide">
   </div>
</div>

<div id="delete-confirm-modal" class="modal-backdrop" onclick="closeModalOnBackdrop(event,'delete-confirm-modal')">
  <div class="modal-box narrow" style="text-align:center;">
    <div class="modal-body" style="display:flex;flex-direction:column;align-items:center;gap:20px;padding:40px 32px;">
      <div
        style="width:64px;height:64px;border-radius:50%;background:rgba(255,180,171,0.1);display:flex;align-items:center;justify-content:center;">
        <span class="material-symbols-outlined" style="color:var(--error);font-size:32px;">delete_forever</span></div>
      <h2 style="font-family:'Noto Serif',serif;font-size:1.25rem;">Confirm Deletion</h2>
      <p style="font-size:0.875rem;color:var(--on-surface-variant);line-height:1.6;">This action is irreversible. The
        record will be permanently removed.</p>
      <input type="hidden" id="del-id" /><input type="hidden" id="del-type" />
      <div style="display:flex;gap:12px;width:100%;">
        <button onclick="closeModal('delete-confirm-modal')" class="btn-secondary"
          style="flex:1;justify-content:center;">Cancel</button>
        <button onclick="closeModal('delete-confirm-modal');showToast('Record deleted.');"
          style="flex:1;padding:12px;background:rgba(147,0,10,0.6);color:var(--error);border:1px solid rgba(255,180,171,0.2);border-radius:8px;cursor:pointer;font-weight:700;font-size:0.875rem;">Delete</button>
      </div>
    </div>
  </div>
</div>
<?php
include '../../common/FOOTER.php';
?>