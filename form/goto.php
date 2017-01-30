<?php
$dir = $_POST['dir'];
$old = $_GET['OLD'];
if (is_dir($dir)) {
header("Location: /index.php?FS=$dir");
} else {
header("Location: /index.php?FS=$old&err=NO_EXT");
}
?>
