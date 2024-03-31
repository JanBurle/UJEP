<?php defined('_PHP_INCLUDE_') or die;

$xml = new DOMDocument;
$xml->load('../xml/studium.xml');

$xsl = new DOMDocument;
$xsl->load("../xml/studium-uloha-$uloha.xsl");

$xslt = new XSLTProcessor();
$xslt->importStylesheet($xsl);

echo $xslt->transformToXml($xml);

