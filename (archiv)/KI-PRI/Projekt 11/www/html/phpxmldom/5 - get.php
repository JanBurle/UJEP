<!DOCTYPE html>
<html>

<head>
</head>

<body>
<pre>

<?php
$doc = new DOMDocument();
$doc->load('../../xml/knihy.xml');

$knihy = $doc->getElementsByTagName('kniha');

print_r($knihy);

$kniha2 = $knihy[1];
print_r($kniha2);

$attrs = $kniha2->attributes;
print_r($attrs);

$lang = $kniha2->getAttribute('lang');
$nazev = $kniha2->firstElementChild;

echo 'Kniha 2: ' . $nazev->textContent . ' (' . $lang . ')';

?>
</pre>

</body>

</html>