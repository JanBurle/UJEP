<?php

$xml = file_get_contents('../xml-side/fakulta.xml');
// nějaké zpracování ...
header('Content-Type: application/xml');
echo $xml;
