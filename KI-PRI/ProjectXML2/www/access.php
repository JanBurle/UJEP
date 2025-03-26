<?
$xml = simplexml_load_file('xml/fakulta.xml');

echo (string)($xml->fakulta[0]->dekan->jmeno);
