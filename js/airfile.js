function active(type) {
if (type == "goto") {
document.getElementById("tmp").innerHTML = '<div class="tmp"><center><form action="form/goto.php" method="post"><input type="text" name="dir" class="imp"><input class="imp" type="submit" value="go"></form></center></div>';
}
}
