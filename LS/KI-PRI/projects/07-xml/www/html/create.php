<?
$withStyle = false;

// XML root element
if ($withStyle)
  $xml = new SimpleXMLElement('<?xml-stylesheet type="text/xsl" href="xml/fakulta.xsl"?><fakulty/>');
else
  $xml = new SimpleXMLElement('<fakulty/>');

// add children
$fakulta = $xml->addChild('fakulta');
$fakulta->addAttribute('id', 'Pri');

$dekan = $fakulta->addChild('dekan');
$dekan->addChild('jmeno', 'Michal');
$dekan->addChild('prijmeni', 'Varady');
$dekan->addChild('email', 'm.v@gmail.com');

// send XML to client
header('Content-Type: application/xml');
echo $xml->asXML();
