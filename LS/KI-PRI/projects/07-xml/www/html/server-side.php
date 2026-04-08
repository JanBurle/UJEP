<!DOCTYPE html>
<html lang="cs">

<? $title = 'XML validátor' ?>

<head>
  <title><?= $title ?></title>
</head>

<body>
  <?
  $xml = new DOMDocument;
  $xml->load('xml/cdcatalog.xml');
  // XSL
  $xsl = new DOMDocument;
  $xsl->load('xml/cdcatalog.xsl');
  // transformer
  $xslt = new XSLTProcessor();
  $xslt->importStylesheet($xsl);
  // transform XML
  $transXml = $xslt->transformToXml($xml);
  // output
  echo $transXml;
  ?>
</body>

</html>
