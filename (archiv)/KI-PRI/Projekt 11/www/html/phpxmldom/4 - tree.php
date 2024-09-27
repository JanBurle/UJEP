<!DOCTYPE html>
<html>

<head>
</head>

<body>
<pre>

<?php
$doc = new DOMDocument();
$doc->load('../../xml/knihy.xml');

function printElem($elem, $level=0) {
    if ('#text' == $name = $elem->nodeName)
        return;

    echo str_pad('', 2*$level) . $name;

    if (@$elem->childElementCount) {
        echo "\n";
        foreach ($elem->childNodes AS $child)
            printElem($child, $level+1);
    } else {
        echo ' = ' . trim($elem->nodeValue) . "\n";
    }
}

printElem($doc->documentElement);
?>
</pre>

</body>

</html>