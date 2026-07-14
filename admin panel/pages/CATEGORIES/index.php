<!-- common links -->
 
<?php 
session_start();

if($_SESSION['role']!='admin'){
  header("location: login.php");
  exit();
}
?>
<?php 

// use LDAP\Result;
include '../../common/header.php';
?>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="../../assets/css/style.css">
<script src="../../assets/js/script.js"></script>
<?php 
//  include('update.php');
include('../../config/conn.php');
 ?>


<!-- php logic for catergory add -->
<?php
if(isset($_POST['submit'])){
     $c_name = $_POST['c_name'];
  $c_desc = $_POST['c_description'];
  $c_status = $_POST['c_status'];

  $c_image = $_FILES['c_image']['name'];
  $tmp_name = $_FILES['c_image']['tmp_name'];
    $extension=pathinfo($c_image,PATHINFO_EXTENSION);
    $validextension=['png','jpg','jpeg','avif','webp'];
    $validfile=in_array( $extension, $validextension);
    if($validfile){
        move_uploaded_file($tmp_name,'../../assets/images/'.$c_image);
        $add_query= "INSERT INTO category (c_name ,c_description ,c_image ,c_status) VALUES ('$c_name' ,'$c_desc','$c_image','$c_status')";
  
        if(mysqli_query($conn, $add_query)){
            echo "<script>alert('Category Added Successfully');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }


}
?>

<!-- php logic for catergory add end  -->



<!-- php logic for catergory read  -->
<?php 
$show_query = "SELECT * FROM `category`";

$Result = mysqli_query($conn , $show_query);
?>


<!-- php logic for catergory read  end-->


<!-- php logic for catergory update  start-->
<?php




?>






<!-- php logic for catergory update  end-->







<!-- html start -->
<body>



<div class="page-content">
  <div class="page-header">
    <div class="page-title"><h2 class="font-serif">Categories Management</h2><p>Manage product categories and classifications</p></div>
    <button class="btn-primary" onclick="openModal('add-category-modal')"><span class="material-symbols-outlined">add</span>Add Category</button>
  </div>
  <div class="filter-bar">
    <select class="filter-select"><option>All Status</option><option>Active</option><option>Inactive</option></select>
    <select class="filter-select"><option>Sort by Name</option><option>Sort by Products</option><option>Newest First</option></select>
  </div>

<!-- show data here -->

  <div class="table-card">
          <table>
            <thead>
              <tr>
                <th>id</th>
                <th>Category_Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th style="text-align:right;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($Result as $data){?>
              <tr>
                <td style="font-family:monospace;font-size:0.75rem;color:var(--on-surface-variant);">
                  <?php echo $data['c_id']?>
                </td>
                <td style=" font-weight:600;">
                  <?php echo $data['c_name']?>
                </td>
                <td style="font-family:monospace;font-size:0.75rem;color:var(--on-surface-variant);">
                  <?php echo $data['c_description']?>
                </td>
                <td>
                  <span class="material-symbols-outlined" style="color:var(--primary);"> 
                    <img src="../../assets/images/<?php echo $data['c_image']?>" height="70px" alt="">
                  </td>
                <td>
                  <span class="badge badge-green">
                    <?php echo $data['c_status']?>
                  </span>
                </td>
                <td style="text-align:right;">
                  <a href="update.php?id=<?php echo $data['c_id']?>">
                  <button class="btn-icon" onclick="openEditCategory()">
                    <span class="material-symbols-outlined">edit</span>
                  </button>
                </a>
                <a href="deletecategory.php?id=<?php echo $data['c_id']?>">
                <button class="btn-icon danger" onclick="openDeleteModal()">
                      <span class="material-symbols-outlined">delete</span>
                    </button>
                  </a>
                </td>
              </tr>
              <?php }?>
              
            </tbody>
          </table>
          <div class="table-pagination">
            <p>Showing <strong>4</strong> of <strong>4</strong> categories</p>
          </div>
        </div>
</div>




<!-- edit form -->





<div id="add-category-modal" class="modal-backdrop" onclick="closeModalOnBackdrop(event,'add-category-modal')">
  <div class="modal-box">

    <div class="modal-header">
      <div>
        <h2>Add Category</h2>
        <p>New Product Classification</p>
      </div>
      <button class="close-btn" onclick="closeModal('add-category-modal')">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>

    <div class="modal-body">

      <form method="POST" enctype="multipart/form-data">

        <div style="display:flex;flex-direction:column;gap:20px;">

          <!-- NAME -->
          <div class="form-group">
            <label class="form-label">Category Name</label>
            <input type="text" name="c_name" class="form-input" placeholder="e.g. Limited Editions" required/>
          </div>

          <!-- DESCRIPTION -->
          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="c_description" class="form-textarea" placeholder="Brief description..."></textarea>
          </div>

          <!-- IMAGE -->
          <div class="form-group">
            <label class="form-label">Category Image</label>
            <input type="file" name="c_image" class="form-input"/>
          </div>

          <!-- STATUS -->
          <div class="form-group">
            <label class="form-label">Status</label>
            <select name="c_status" class="form-select">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn-ghost" onclick="closeModal('add-category-modal')">Cancel</button>
          <input type="submit" name="submit" class="btn-primary" value="Add Category">
        </div>

      </form>

    </div>
  </div>
</div>










<div id="delete-confirm-modal" class="modal-backdrop" onclick="closeModalOnBackdrop(event,'delete-confirm-modal')">
  <div class="modal-box narrow" style="text-align:center;">
    <div class="modal-body" style="display:flex;flex-direction:column;align-items:center;gap:20px;padding:40px 32px;">
    <div style="width:64px;height:64px;border-radius:50%;background:rgba(255,180,171,0.1);display:flex;align-items:center;justify-content:center;">
      <span class="material-symbols-outlined" style="color:var(--error);font-size:32px;">delete_forever</span>
    </div>
    <h2 style="font-family:'Noto Serif',serif;font-size:1.25rem;">Confirm Deletion</h2>
    <p style="font-size:0.875rem;color:var(--on-surface-variant);line-height:1.6;">This action is irreversible.</p>
    <input type="hidden" id="del-id"/>
    <input type="hidden" id="del-type"/>
    <div style="display:flex;gap:12px;width:100%;">
      <button onclick="closeModal('delete-confirm-modal')" class="btn-secondary" style="flex:1;justify-content:center;">Cancel</button>
      <button onclick="closeModal('delete-confirm-modal');showToast('Record deleted.');" style="flex:1;padding:12px;background:rgba(147,0,10,0.6);color:var(--error);border:1px solid rgba(255,180,171,0.2);border-radius:8px;cursor:pointer;font-weight:700;font-size:0.875rem;">
        Delete
      </button>
    </div>
  </div>
</div>
</div>
</div>


<script src="../assets/js/script.js"></script>
<script>(function(){var p=location.pathname.split('/').pop();document.querySelectorAll('.nav-link[href]').forEach(function(l){if(l.getAttribute('href')==p)l.classList.add('active');});})();</script>
</body>







<!-- footer link -->
<?php 
include '../../common/footer.php';
?>