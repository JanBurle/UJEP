<?
$xml = new DOMDocument;
$xml->load('../xml/studium.xml');

$xsl = new DOMDocument;
$xsl->load('../xml/studium-1.xsl');
// $xsl->load('../xml/studium-2.xsl');

$xslt = new XSLTProcessor();
$xslt->importStylesheet($xsl);

echo $xslt->transformToXml($xml);
