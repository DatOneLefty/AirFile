<?php
session_start();
$_SESSION['access-password'] = "";
header("Location: /index.php?FS=/home");
?>
