<?php
$xml = new DOMDocument;
$xml->load('../xml/studium.xml');

$xsl = new DOMDocument;
$xsl->load('../xml/studium-1-a.xsl');
// $xsl->load('../xml/studium-1-b.xsl');
// $xsl->load('../xml/studium-1-c.xsl');
// $xsl->load('../xml/studium-1-d.xsl');

$xslt = new XSLTProcessor();
$xslt->importStylesheet($xsl);

echo $xslt->transformToXml($xml);

