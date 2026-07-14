<?php
include('../../config/conn.php');
$deletedid=$_GET['id'];
$query="Delete from category where c_id=$deletedid";
if(mysqli_query($conn,$query)){
    header("Location:index.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>