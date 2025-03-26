<?
$xml = simplexml_load_file('xml/fakulta.xml');

echo '<pre>';
print_r($xml->xpath('/fakulty/fakulta[@id="Pri"]/dekan'));
echo '</pre>';
