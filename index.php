<head>
<title>OnlineFiles</title>
<link rel="stylesheet" type="text/css" href="of.css?id=3">
</head>

<body>
<div class='nav'>
<button>File</button>
<button>Edit</button>
<button>View</button>
</div>
<div class='hold'>

<?php
session_start();
if($_SESSION['access-password'] == "password here") {
?>
<table>
<tr><td></td><td>Name</td><td>Last Edited</td><td>Size</td></tr>
<?php
function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}
$files = preg_grep('/^([^.])/', scandir($_GET['FS']));
$to = $_GET['FS'] .  "/..";
echo("<tr><td></td><td><img src='icns/back.png' width='20px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='back' href='index.php?FS=$to'>Back</a></td><td>" ."</td><td>" ."</td></tr>");
$i = 0;
foreach($files as $file) {
	$i++;
  if (is_dir($_GET['FS'] . "/" . $file)) {
	$fmt = $_GET['FS'] . "/" . $file;
	echo("<tr id='$i'><td></td><td><img src='icns/folder.png' width='20px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='folder' href='index.php?FS=$fmt'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>Folder</td></tr>");
	} else {
  echo("<tr id='$i' onclick='select(" . '"' . $i .  '"' .");' style='old'><td></td><td>&#160;<img src='icns/file.png' width='15px' height='20px'></img>&#160;&#160;&#160;&#160;&#160;<a class='file'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>" . formatBytes(filesize($_GET['FS'] . "/" . $file)) ."</td></tr>");
	}
}
?>
</table>
<?php
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
