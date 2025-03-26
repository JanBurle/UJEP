<?php
$xml = simplexml_load_file('xml/fakulta.xml');

print_r($xml->xpath('/fakulty/fakulta[@id="Pri"]/dekan'));
