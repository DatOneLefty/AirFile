<head>
<title>AirFile - File Viewer</title>
<link rel="stylesheet" type="text/css" href="css/normal.css?i=3">
<script src='js/airfile.js?v=2'></script>
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
<div class="dropdown">
  <button>File</button>
  <div class="dropdown-content">
    <a onclick='active("goto");'>Go To Dir</a><br>
    <a>Prefrences</a>
  </div>
</div>
<div class="dropdown">
  <button>View</button>
  <div class="dropdown-content">
    <a>Dark</a><br>
    <a>None</a>
  </div>
</div>
</div>
<div class='hold'>

<?php
if (isset($_GET['err'])) {
if ($_GET['err'] == "NO_EXT") {
echo '<div class="tmp"><center>The directory you tried to go to didn`t exist</center></div>';
}
} else {
echo "<div id='tmp'></div>";
}
?>
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
$f = 0;
$d = 0;
foreach($files as $file) {
	$i++;
	if (is_readable($_GET['FS'] . "/" . $file)) {
		$read = True;
	} else {
		$read = False;
	}
  if (is_dir($_GET['FS'] . "/" . $file)) {
	$fmt = $_GET['FS'] . "/" . $file;
	$d++;
	if ($read == True) {
	echo("<tr id='$i'><td></td><td><img src='icns/folder.png' width='20px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='folder' href='index.php?FS=$fmt'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>Folder</td></tr>");
	} else {
		echo("<tr id='$i'><td></td><td><img src='icns/folder.png' width='20px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='unre' href='index.php?FS=$fmt'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>Folder</td></tr>");
	}
	} else {
	$icon = findend($file);
	$fmt = $_GET['FS'] . "/" . $file;
	$f++;
	if ($read == True) {
	$size = filesize($_GET['FS'] . "/" . $file);
	$totalsize = $totalsize + $size;
  echo("<tr id='$i' onclick='select(" . '"' . $i .  '"' .");' style='old'><td></td><td>&#160;<img src='icns/$icon' width='15px' height='20px'></img>&#160;&#160;&#160;&#160;&#160;<a class='file' href='external/aedit/?FILE=$fmt'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>" . formatBytes($size) ."</td></tr>");
	} else {
  echo("<tr id='$i' onclick='select(" . '"' . $i .  '"' .");' style='old'><td></td><td>&#160;<img src='icns/$icon' width='15px' height='20px'></img>&#160;&#160;&#160;&#160;&#160;<a class='unre'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>" . formatBytes(filesize($_GET['FS'] . "/" . $file)) ."</td></tr>");
	}
	}
}
echo '</table>';
echo "<br><center>a total of $f files taking up " . formatBytes($totalsize) . "(excluding unreadable files)";
echo "<br>There is also $d folders";
echo "<br> In total there are " . ($f + $d) . " files and directories</center>";
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

function active(type) {
if (type == "goto") {
document.getElementById("tmp").innerHTML = httpGet("pane_html/goto.html");
}
}
</script>
