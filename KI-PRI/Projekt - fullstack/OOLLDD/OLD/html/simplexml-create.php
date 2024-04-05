<?php
// Bez stylu:
$xml = new SimpleXMLElement('<fakulty/>');
// Se stylem
$xml = new SimpleXMLElement('<?xml-stylesheet type="text/xsl" href="xml/fakulta.xsl"?><fakulty/>');

$fakulta = $xml->addChild('fakulta');
$fakulta->addAttribute('id','Pri');

$dekan = $fakulta->addChild('dekan');
$dekan->addChild('jmeno','Michal');
$dekan->addChild('prijmeni','Varady');
$dekan->addChild('email','m.v@gmail.com');

header('Content-Type: application/xml');
echo $xml->asXML();
