<?
$xml = simplexml_load_file('xml/student.xml');

echo '<pre>';
$obj = $xml->xpath('/studenti/student[@st="98423"]/jmeno');
print_r($obj);
echo $obj[0];
echo '</pre>';
