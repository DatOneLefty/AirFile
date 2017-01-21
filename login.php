<?php
session_start();
$_SESSION['access-password'] = $_POST['password'];
header("Location: index.php?FS=/home");
?>
