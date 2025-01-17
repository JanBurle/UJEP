<?php
$xml = simplexml_load_file('xml/fakulta.xml');

// prolézt celý strom
function traverseSimpleXML($xml, $level = 0)
{
    $space = fn($level) => str_repeat(' ', $level * 2);

    $attributes = $xml->attributes();

    foreach ($attributes as $name => $value) {
        echo $space($level) . "$name - " . (string) $value . "\n";
    }

    $children = $xml->children();
    foreach ($children as $name => $value) {
        if (0 < $value->count()) {
            echo $space($level) . "$name: \n";
            traverseSimpleXML($value, $level + 1);
        } else {
            echo $space($level) . "$name = " . (string) $value . "\n";
        }
    }
}

echo '<pre>';
traverseSimpleXML($xml);
echo '</pre>';
