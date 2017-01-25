<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<style>
</style>



<head>
<title>AirFile - File Viewer</title>
<link rel="stylesheet" type="text/css" href="/css/normal.css?i=2">
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


require '../../functions.php';
session_start();
if($_SESSION['access-password'] == "password here") {
?>

<div class='nav'>

<div class="dropdown">
  <button>File</button>
  <div class="dropdown-content">
    <a>Save</a><br>
    <a href='/index.php?FS=<?php echo dirname($_GET['FILE']) ?>'>Exit</a><br>
    <a>Prefrences</a>
  </div>
</div>

<div class="dropdown">
  <button>View</button>
  <div class="dropdown-content">
    <a>Dark Theme</a><br>
    <a>None</a>
  </div>
</div>


</div>

<body>
<div class='editor'>

<?php
$file = fopen($_GET['FILE'], "r");

while(!feof($file))
  {
  echo "<input class='ent' value='" . fgets($file) . "'></input>";
  }
fclose($file);

?>
</div>
</body>

<?php
}
}
?>
