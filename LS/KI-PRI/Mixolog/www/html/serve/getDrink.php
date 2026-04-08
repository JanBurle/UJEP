<?php // přečti a odešli XML soubor s receptem

$drink = @$_GET['drink'];
$file = "/var/mixolog/drinks/$drink.xml";

header("Content-type: text/xml;");
if (file_exists($file))
    readfile($file);