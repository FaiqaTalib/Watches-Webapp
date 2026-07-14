<?php
include('../../config/conn.php');
$deletedid=$_GET['id'];
$query="Delete from products where p_id=$deletedid";
if(mysqli_query($conn,$query)){
    header("Location:index.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>