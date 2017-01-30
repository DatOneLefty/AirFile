function httpGet(theUrl)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
    xmlHttp.send( null );
    return xmlHttp.responseText;
}

function select(iteid) {
  document.getElementById(iteid).style.property = "selected";
 document.getElementById(old).style.property = "none";
 old = iteid;
}
