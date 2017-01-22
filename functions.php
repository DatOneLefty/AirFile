<?php
function findend($filename) {

$info = new SplFileInfo($filename);
$ending =$info->getExtension();


if ($ending == "iso") {
return "disk.png";
}

else if ($ending == "img") {
return "disk.png";
}

else if ($ending == "dmg") {
return "disk.png";
}

else if ($ending == "iso") {
return "disk.png";
}

else if ($ending == "txt") {
return "file.png";
}

else {
return "file.png";
}

}

?>
