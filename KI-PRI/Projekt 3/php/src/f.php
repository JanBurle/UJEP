<!DOCTYPE html>
<html>

<body>

    <a href='xml/cdcatalog.xml'>xml</a>

    <?php $files = glob('xml/*.xml');
    foreach ($files as $file) { ?>
        <a href='<?= $file ?>'>
            <?= $file ?>
        </a>
    <?php } ?>

    <?php
    $xml = new DOMDocument;
    $xml->load('xml/cdcatalog.xml');
    $xsl = new DOMDocument;
    $xsl->load('xml/cdcatalog.xsl');
    $xslt = new XSLTProcessor();
    $xslt->importStylesheet($xsl);
    $transformovany_xml = $xslt->transformToXml($xml);
    echo $transformovany_xml;
?>

</body>

</html>