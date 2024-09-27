<?php

$xml = new DOMDocument;
$xml->load('../xml-side/studium.xml');

$xsl = new DOMDocument;
$xsl->load("../xml-side/studium-$uloha.xsl");

$xslt = new XSLTProcessor();
$xslt->importStylesheet($xsl);

echo $xslt->transformToXml($xml);

