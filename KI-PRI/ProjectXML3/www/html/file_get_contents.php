<?
$xml = file_get_contents('../xml/fakulta.xml');

// Process $xml > XML DOM > $xml ...

header('Content-Type: application/xml');
echo $xml;
