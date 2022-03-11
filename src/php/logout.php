<?php
session_start();
$_SESSION["flag"] = 0;
$_SESSION["isAdmin"] = false;
$_SESSION["username"] = null;
header("Location: ../../public/login.php");
?>


