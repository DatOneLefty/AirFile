<?php
session_start();
$USERNAME = $_GET['USERNAME'];
$_SESSION['access-password'] = $_POST['password'];
header("Location: index.php?FS=/home/$USERNAME&USERNAME=$USERNAME");
?>
