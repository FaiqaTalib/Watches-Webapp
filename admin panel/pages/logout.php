<?php
session_start();
session_destroy();
header("Location: ../../../../e-project/user_panel/pages/login.php");
?>