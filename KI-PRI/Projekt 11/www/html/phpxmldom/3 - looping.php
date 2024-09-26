<!DOCTYPE html>
<html>

<head>
</head>

<body>

<?php
$doc = new DOMDocument();
$doc->load('../../xml/knihy.xml');

echo "<h3>doc</h3>\n";
echo "\n<pre>\n";

print_r($doc);

echo "\n</pre><hr><h3>documentElement</h3>\n<pre>\n";

$elem = $doc->documentElement;
print_r($elem);

echo "\n</pre><hr><h3>childNodes</h3><pre>\n";

foreach ($elem->childNodes AS $node) {
    print_r($node);
}

echo "\n</pre>\n";

?>

</body>

</html>