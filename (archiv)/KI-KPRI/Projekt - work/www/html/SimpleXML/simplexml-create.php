<?php
$xml = new SimpleXMLElement('<fakulty/>');

$fakulta = $xml->addChild('fakulta');
$fakulta->addAttribute('id', 'Pri');

$dekan = $fakulta->addChild('dekan');
$dekan->addChild('jmeno', 'Michal');
$dekan->addChild('prijmeni', 'Varady');
$dekan->addChild('email', 'm.v@gmail.com');

header('Content-Type: application/xml');
echo $xml->asXML();
