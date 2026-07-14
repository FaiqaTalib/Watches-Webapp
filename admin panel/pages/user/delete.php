<?php
include('../../config/conn.php');
$deletedid=$_GET['id'];
$query="Delete from users where id=$deletedid";
if(mysqli_query($conn,$query)){
    header("Location:employees.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>