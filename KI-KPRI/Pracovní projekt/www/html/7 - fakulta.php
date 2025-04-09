<?php

$xml = file_get_contents('../xml-aside/fakulta.xml');
// nějaké zpracování ...
header('Content-Type: application/xml');
echo $xml;
