<head>
<title>AirFile - File Viewer</title>
<link rel="stylesheet" type="text/css" href="css/normal.css?i=2">
</head>

<body>
<?php

$whitelist = array(
    '127.0.0.1',
    '::1'
);

if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
        die('Access Denied');
} else {


require 'functions.php';
session_start();
if($_SESSION['access-password'] == "password here") {
?>
<div class='nav'>
<button>File</button>
<button>Edit</button>
<button>View</button>
</div>
<div class='hold'>


<?php
function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}
$files = preg_grep('/^([^.])/', scandir($_GET['FS']));
$a = 0;
foreach($files as $file) {
$a++;
}
?>
<?php
if ($a < 1) {
?>
<center>
<img src='icns/folder.png'>
<h1>No files here!</h1>
<?php
$to = $_GET['FS'] .  "/..";
echo "<img src='icns/back.png' width='20px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='back' href='index.php?FS=$to'>Back</a>";
?>
</center>
<?php
} else {
?>
<table>
<tr><td></td><td><b>Name</b></td><td><b>Last Edited</b></td><td><b>Size</b></td></tr>
<?php
$to = $_GET['FS'] .  "/..";
echo("<tr><td></td><td><img src='icns/back.png' width='20px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='back' href='index.php?FS=$to'>Back</a></td><td>" ."</td><td>" ."</td></tr>");
$i = 0;
foreach($files as $file) {
	$i++;
	if (is_readable($_GET['FS'] . "/" . $file)) {
		$read = True;
	} else {
		$read = False;
	}
  if (is_dir($_GET['FS'] . "/" . $file)) {
	$fmt = $_GET['FS'] . "/" . $file;
	if ($read == True) {
	echo("<tr id='$i'><td></td><td><img src='icns/folder.png' width='20px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='folder' href='index.php?FS=$fmt'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>Folder</td></tr>");

	} else {
		echo("<tr id='$i'><td></td><td><img src='icns/folder.png' width='20px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='unre' href='index.php?FS=$fmt'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>Folder</td></tr>");

	}
	} else {
	$icon = findend($file);
	if ($read == True) {
  echo("<tr id='$i' onclick='select(" . '"' . $i .  '"' .");' style='old'><td></td><td>&#160;<img src='icns/$icon' width='15px' height='20px'></img>&#160;&#160;&#160;&#160;&#160;<a class='file'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>" . formatBytes(filesize($_GET['FS'] . "/" . $file)) ."</td></tr>");
	} else {
  echo("<tr id='$i' onclick='select(" . '"' . $i .  '"' .");' style='old'><td></td><td>&#160;<img src='icns/$icon' width='15px' height='20px'></img>&#160;&#160;&#160;&#160;&#160;<a class='unre'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>" . formatBytes(filesize($_GET['FS'] . "/" . $file)) ."</td></tr>");
	}
	}
}
echo '</table>';
?>
<?php
}
} else {
?>
<center>
<form action="login.php" method="post">
Access Password: <input type="password" name="password"><br>
<input type="submit">
</form>
</center>
<?php
}
}
?>
</div>
</body>
<script>
var old = 1;
function select(iteid) {
  document.getElementById(iteid).style.property = "selected";
 document.getElementById(old).style.property = "none";
 old = iteid;
}
</script>
