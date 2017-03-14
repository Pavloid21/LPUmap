<?php
require("db_info.php");
 
function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 
 
// Выбираем данные о маркерах из таблицы
$query = "SELECT * FROM markers WHERE 1";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
 
header("Content-type: text/xml");
 
// Начало XML-файла, вывод с помощью echo
$dom = new DOMDocument('1.0','utf-8');
$markers = $dom->appendChild($dom->createElement('markers'));
 
// Повторяем вывод для каждой записи
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  $marker = $markers->appendChild($dom->createElement('marker'));
  $name = $marker->appendChild($dom->createElement('name', parseToXML($row['name']) ));
  $address = $marker->appendChild($dom->createElement('address', parseToXML($row['address']) ));
  $lat = $marker->appendChild($dom->createElement('lat', $row['lat'] ));
  $lng = $marker->appendChild($dom->createElement('lng', $row['lng'] ));
  $awpCount = $marker->appendChild($dom->createElement('awpCount', $row['awpCount']));
  $awpClinicCount = $marker->appendChild($dom->createElement('awpClinicCount', $row['awpClinicCount']));
  $awpHospCount = $marker->appendChild($dom->createElement('awpHospCount', $row['awpHospCount']));
  $awpOtherStaffCount = $marker->appendChild($dom->createElement('awpOtherStaffCount', $row['awpOtherStaffCount']));
  //$marker->setAttribute("name", parseToXML($row['name']));
  //$marker->setAttribute("address", parseToXML($row['address']));
  //$marker->setAttribute("lat", $row['lat']);
  //$marker->setAttribute("lng", $row['lng']);
}
 
//Конец XML-файла
//$xml = new SimpleXMLElement($string);
$dom->formatOutput = true;
$dom->save("markers.xml");
 
?>