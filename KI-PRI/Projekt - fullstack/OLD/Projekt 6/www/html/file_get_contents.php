<?php
$xml = file_get_contents('../xml/fakulta.xml');

header('Content-Type: application/xml');
echo $xml;
