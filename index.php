<head>
<title>AirFile - File Viewer</title>
<link rel="stylesheet" type="text/css" href="css/normal.css?i=5">
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
    <a href='form/logout.php'>Lock</a>
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
<table height="100%">
<tr valign=top>
<td width='20%' bgcolor="lightgray">
<div class='hold'>
<table>
<?php
echo "<b>User Files</b>";
$USERNAME = $_GET['USERNAME'];
echo "<tr><td><img src='icns/sidebar/home.png' width='15px' height='15px'>  <a class='folder' href='index.php?FS=/home/$USERNAME&USERNAME=$USERNAME'>Home</a></td></tr>";
echo "<tr><td><img src='icns/sidebar/desktop.png' width='15px' height='15px'>  <a class='folder' href='index.php?FS=/home/$USERNAME/Desktop&USERNAME=$USERNAME'>Desktop</a></td></tr>";
echo "<tr><td><img src='icns/sidebar/document.png' width='15px' height='15px'>  <a class='folder' href='index.php?FS=/home/$USERNAME/Documents&USERNAME=$USERNAME'>Documents</a></td></tr>";
echo "<tr><td><img src='icns/sidebar/download.png' width='15px' height='15px'>  <a class='folder' href='index.php?FS=/home/$USERNAME/Downloads&USERNAME=$USERNAME'>Downloads</a></td></tr>";
echo "<tr><td><img src='icns/sidebar/music.png' width='15px' height='15px'>  <a class='folder' href='index.php?FS=/home/$USERNAME/Music&USERNAME=$USERNAME'>Music</a></td></tr>";
echo "<tr><td><a class='folder' href='index.php?FS=/home/$USERNAME/Pictures&USERNAME=$USERNAME'>Pictures</a></td></tr>";
echo "<tr><td><a class='folder' href='index.php?FS=/home/$USERNAME/Videos&USERNAME=$USERNAME'>Videos</a></td></tr>";
?>
</table>
<hr>
</div>
</td>
<td>
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

$filelist = file_get_contents("data/use_list");
?>
</center>
<?php
} else {
if ($filelist != "false") {
?>
<table>
<tr><td></td><td><b>Name</b></td><td><b>Last Edited</b></td><td><b>Size</b></td></tr>
<?php
}
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
	if ($filelist == "false") {
	echo "<div class='image' ><figure><img href='index.php?FS=$fmt' src='icns/folder.png' alt='missing'  width='80px' height='80px'/><figcaption href='index.php?FS=$fmt'>$file</figcaption></figure></div>";
	} else {
	echo("<tr id='$i'><td></td><td><img src='icns/folder.png' width='15px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='folder' href='index.php?FS=$fmt'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>Folder</td></tr>");
	}
	} else {
		echo("<tr id='$i'><td></td><td><img src='icns/folder.png' width='15px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='unre' href='index.php?FS=$fmt'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>Folder</td></tr>");
	}
	} else {
	$icon = findend($file);
	$fmt = $_GET['FS'] . "/" . $file;
	$f++;
	if ($read == True) {
	$size = filesize($_GET['FS'] . "/" . $file);
	$totalsize = $totalsize + $size;
	if ($filelist == "false") {
	echo "<div class='image' ><figure><img href='external/aedit/?FILE=$fmt' src='icns/file.png' alt='missing' width='80px' height='80px' /><figcaption href='external/aedit/?FILE=$fmt'>$file</figcaption></figure></div>";
	} else {
  echo("<tr id='$i' onclick='select(" . '"' . $i .  '"' .");' style='old'><td></td><td>&#160;<img src='icns/$icon' width='15px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='file' href='external/aedit/?FILE=$fmt'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>" . formatBytes($size) ."</td></tr>");
}
	} else {
  echo("<tr id='$i' onclick='select(" . '"' . $i .  '"' .");' style='old'><td></td><td>&#160;<img src='icns/$icon' width='15px' height='15px'></img>&#160;&#160;&#160;&#160;&#160;<a class='unre'>$file</a></td><td>" . date ("F d Y H:i:s", filemtime($_GET['FS'] . "/" . $file)) .  "</td><td>" . formatBytes(filesize($_GET['FS'] . "/" . $file)) ."</td></tr>");
	}
	}
}
echo '</table>';
echo "<br><center>a total of $f files taking up " . formatBytes($totalsize) . "(excluding unreadable files)";
echo "<br>There is also $d folders";
echo "<br> In total there are " . ($f + $d) . " files and directories</center>";
?>
</tr>
</td>
</table>
<?php
}
} else {
?>
<center>
<div class='hold'>
<h1>This AirFile system is locked</h1>
<h3>Please enter the AirFile password</h3>
<form action="login.php" method="post">
Access Password: <input type="password" name="password"><br>
<input type="submit">
</form>
</div>
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
document.getElementById("tmp").innerHTML = httpGet("pane_html/goto.php?FS=<?php echo $_GET['FS']; ?>&USERNAME=<?php echo $_GET['USERNAME']; ?>");
}
}
</script>
