<?php

$xml = new DOMDocument;
$xml->load('../xml-aside/studium.xml');

$xsl = new DOMDocument;
$xsl->load("../xml-aside/studium-$uloha.xsl");

$xslt = new XSLTProcessor();
$xslt->importStylesheet($xsl);

echo $xslt->transformToXml($xml);

