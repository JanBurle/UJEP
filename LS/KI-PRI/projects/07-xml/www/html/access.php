<?
$xml = simplexml_load_file('xml/student.xml');

echo $xml->student[0]->jmeno;
