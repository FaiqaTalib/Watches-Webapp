<!-- common links -->
 
<?php 
session_start();

if($_SESSION['role']!='admin'){
  header("location: login.php");
  exit();
}
?>

<?php 

include '../../common/header.php';
?>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="../../assets/css/style.css">
<script src="../../assets/js/script.js"></script>
<?php 
//  include('update.php');
include('../../config/conn.php');



$updatedid = $_GET['id'];
$query="Select * from category where c_id=$updatedid";
$Result=mysqli_query($conn,$query);
foreach($Result as $data)
{
    $c_name=$data['c_name'];
    $c_desc=$data['c_description'];
  
}
 ?>






<?php
if(isset($_POST['update'])){
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
       $update_query = "UPDATE category SET c_name='$c_name', c_description='$c_desc', c_image='$c_image', c_status='$c_status' WHERE c_id=$updatedid"; 
        if(mysqli_query($conn, $update_query)){
            echo "<script>alert('Category Update Successfully');</script>";
            echo "<script>window.location.href='index.php'</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }


}
?>





    <div class="modal-header">
      <div>
        <h2>Edit Category</h2>
        <p>Update Details</p>
    </div>
    </div>


  <div class="modal-body">
     <form enctype="multipart/form-data" method="post">

  <input type="hidden" name="id" id="ecat-id"/>

  <div style="display:flex;flex-direction:column;gap:20px;">

    <!-- NAME -->
    <div class="form-group">
      <label class="form-label">Category Name</label>
      <input type="text" name="c_name" id="ecat-name" class="form-input" value="<?php echo $c_name ?>" required/>
    </div>

    <!-- DESCRIPTION -->
    <div class="form-group">
      <label class="form-label">Description</label>
      <textarea name="c_description" id="ecat-description"  class="form-textarea"><?php echo $c_desc ?></textarea>
    </div>

    <!-- IMAGE -->
    <div class="form-group">
      <label class="form-label" >Category Image</label>
      <input type="file" name="c_image" class="form-input" />
    </div>

    <!-- STATUS -->
    <div class="form-group">
      <label class="form-label">Status</label>
      <select name="c_status" id="ecat-status" class="form-select">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>
    </div>

  </div>

  <div class="modal-footer">
    <button type="button" class="btn-ghost" onclick="closeModal('edit-category-modal')">Cancel</button>
    <input type="submit" name="update" class="btn-primary" value="Update Category">
  </div>


</form>






<!-- footer link -->
<?php 
include '../../common/footer.php';
?>

