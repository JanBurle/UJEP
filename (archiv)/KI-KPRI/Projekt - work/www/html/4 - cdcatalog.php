<!DOCTYPE html>
<html>

<body>
    <?php
    // XML
    $xml = new DOMDocument;
    $xml->load('xml/CDs/cdcatalog.xml');
    // XSL
    $xsl = new DOMDocument;
    $xsl->load('xml/CDs/cdcatalog.xsl');
    // transformer
    $xslt = new XSLTProcessor();
    $xslt->importStylesheet($xsl);
    $transformovany_xml = $xslt->transformToXml($xml);
    // output
    echo $transformovany_xml;
    ?>
</body>

</html>