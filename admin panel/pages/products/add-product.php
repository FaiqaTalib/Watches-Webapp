<!-- common links -->
 
<?php 
session_start();

if($_SESSION['role']!='admin'){
  header("location: ../../../../e-project/user_panel/pages/login.php");
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
$query= "select * FROM `category`";
$result=mysqli_query($conn,$query); 
?>




<div class="page-content">
    <div class="page-header">
        <div class="page-title">
            <nav
                style="font-size:10px;text-transform:uppercase;letter-spacing:0.15em;color:rgba(229,226,227,0.4);margin-bottom:8px;">
                <a href="index.php" style="color:inherit;text-decoration:none;"
                    onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='inherit'">Products</a>
                / <span style="color:var(--primary);">New Entry</span>
            </nav>
            <h2 class="font-serif">Add New Product</h2>
        </div>
        <div style="display:flex;gap:12px;">
            
         
        </div>
    </div>






    <form method="post" enctype="multipart/form-data">
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Product Name</label>
                <input type="text" name="p_name" class="form-input" placeholder="name....." />
            </div>
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="p_category" class="form-select">
                    <?php foreach($result as $data) { ?>

                    <option value="<?php echo $data['c_id'] ?>"><?php echo $data['c_name'] ?></option>
                    <?php }?>

                </select>
            </div>
          
            <div class="form-group">
                <label class="form-label">Price (USD)</label>
                <input type="number" name="p_price"
                    class="form-input" placeholder="42000" step="0.01" min="0" />
            </div>
            <div class="form-group">
                <label class="form-label">Stock Qty</label>
                <input type="number" name="p_stock"
                    class="form-input"  min="0" />
                </div>
            <div class="form-group col-full">
                <label class="form-label">Description</label>
                <textarea name="p_desc"
                    class="form-textarea" placeholder="Product description..."></textarea>
                </div>
      
          
            <div class="form-group col-full">
                <label class="form-label">Image</label>
                <input type="file" name="p_image"
                    class="form-input" placeholder=" " />
                </div>

            <div class="form-group col-full">
            <label class="form-label">Status</label>
            <select name="p_status" class="form-select">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

        </div>
        <div class="modal-footer">
            <a href="index.php" class="btn-ghost">Cancel</a>
                <input type="submit" class="btn-primary" value="Save Product" name="submit"/>
            </div>
    </form>
</div>

<?php
if(isset($_POST['submit'])){
     $p_name = $_POST['p_name'];
  $p_desc = $_POST['p_desc'];
  $p_price = $_POST['p_price'];
  $p_stock = $_POST['p_stock'];
    $p_cid = $_POST['p_category'];
      $p_status = $_POST['p_status'];
  $p_image = $_FILES['p_image']['name'];
  $tmp_name = $_FILES['p_image']['tmp_name'];
    $extension=pathinfo($p_image,PATHINFO_EXTENSION);
    $validextension=['png','jpg','jpeg','avif','webp'];
    $validfile=in_array( $extension, $validextension);
    if($validfile){
        move_uploaded_file($tmp_name,'../../assets/images/'.$p_image);
        $add_query= "INSERT INTO products (p_name ,p_desc ,p_price ,p_stock ,p_image , p_cid , p_status) VALUES ('$p_name' ,'$p_desc','$p_price','$p_stock','$p_image','$p_cid', '$p_status')";
  
        if(mysqli_query($conn, $add_query)){
            echo "<script>alert('product Added Successfully');</script>";
            // header("location: index.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }


}





?>








<script>
    function previewImg(input) {
        if (input.files && input.files[0]) {
            var r = new FileReader();
            r.onload = function (e) {
                var d = document.getElementById('dropzone');
                d.style.backgroundImage = 'url(' + e.target.result + ')';
                d.style.backgroundSize = 'cover';
                d.style.backgroundPosition = 'center';
                d.innerHTML = '';
            };
            r.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php
include '../../common/FOOTER.php';
?>