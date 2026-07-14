  
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
include('../../config/conn.php');

$query= "select * FROM `category`";
$result_cate=mysqli_query($conn,$query); 

$updatedid=$_GET['id'];
$query="Select * from products where p_id=$updatedid";
$res=mysqli_query($conn,$query); 
?>
<?php foreach($res as $data ){
    $p_name = $data['p_name'];
  $p_desc = $data['p_desc'];
  
  $p_price = $data['p_price'];
  $p_stock = $data['p_stock'];
  $p_status = $data['p_status'];
    
} ?>

<?php
if(isset($_POST['submit'])){
     $p_name = $_POST['p_name'];
  $p_desc = $_POST['p_desc'];
  $p_price = $_POST['p_price'];
  $p_stock = $_POST['p_stock'];
  $p_status = $_POST['p_status'];

    $p_cid = $_POST['p_category'];
  $p_image = $_FILES['p_image']['name'];
  $tmp_name = $_FILES['p_image']['tmp_name'];
    $extension=pathinfo($p_image,PATHINFO_EXTENSION);
    $validextension=['png','jpg','jpeg','avif','webp'];
    $validfile=in_array( $extension, $validextension);
    if($validfile){
        move_uploaded_file($tmp_name,'../../assets/images/'.$p_image);
     $edit_query = "UPDATE products 
SET p_name = '$p_name',
    p_desc = '$p_desc',
    p_price = '$p_price',
    p_cid = '$p_cid',
    p_status = '$p_status',
    p_image = '$p_image'";
        if(mysqli_query($conn, $edit_query)){
            echo "<script>alert('product Added Successfully');</script>";
            header("location:index.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }


}





?>

  
<div class="page-content">
    <div class="page-header">
        <div class="page-title">
            <nav
                style="font-size:10px;text-transform:uppercase;letter-spacing:0.15em;color:rgba(229,226,227,0.4);margin-bottom:8px;">
                <a href="index.php" style="color:inherit;text-decoration:none;"
                    onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='inherit'">Products</a>
                / <span style="color:var(--primary);">Edit Product</span>
            </nav>
            <h2 class="font-serif">Edit Product</h2>
        </div>
        <div style="display:flex;gap:12px;">
            
         
        </div>
    </div>


    <form method="post" enctype="multipart/form-data">
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Product Name  </label>
                <input type="text" name="p_name" class="form-input" value="<?php echo $data['p_name']?>" />
            </div>
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="p_category" class="form-select">
                    <?php foreach($result_cate as $data_cate) { ?>

                    <option value="<?php echo $data_cate['c_id'] ?>"><?php echo $data_cate ['c_name'] ?></option>
                    <?php }?>


                </select>
            </div>
          
            <div class="form-group">
                <label class="form-label">Price (USD)</label>
                <input type="number" name="p_price"
                    class="form-input" placeholder="42000" value="<?php echo $data['p_price']?>" step="0.01" min="0" />
            </div>
            <div class="form-group">
                <label class="form-label">Stock Qty</label>
                <input type="number" name="p_stock" value="<?php echo $data['p_stock']?>"
                    class="form-input"  min="0" />
                </div>
 
            <div class="form-group col-full">
                <label class="form-label">Description</label>
                <textarea name="p_desc" 
                    class="form-textarea" placeholder="Product description..."><?php echo $data['p_desc']?></textarea>
                </div>

      <div class="form-group col-full">
      <label class="form-label">Status</label>
      <select name="p_status" id="ecat-status" class="form-select">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>
    </div>
          
            <div class="form-group col-full">
                <label class="form-label">Image</label>
                <input type="file" name="p_image"
                    class="form-input" placeholder=" " value="../../assets/images/<?php echo $data['p_image'] ?>"/>
                </div>
        </div>
        <div class="modal-footer">
            <a href="index.php" class="btn-ghost">Cancel</a>
                <input type="submit" class="btn-primary" value="Save Product" name="submit"/>
            </div>
    </form>
</div>



    <?php
include '../../common/FOOTER.php';
?> 