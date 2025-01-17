<?php
$doc = new DOMDocument();
$doc->formatOutput = true; // pretty print

function makeChild($parent, $tag, $value=null) {
    global $doc;
    $child = $doc->createElement($tag);
    if ($value) $child->nodeValue = $value;
    $parent->appendChild($child);
    return $child;
}

function addAttr($elem, $name, $value) {
    // global $doc;
    // $attr = $doc->createAttribute($name);
    // $attr->value = $value;
    // $elem->appendChild($attr);
    $elem->setAttribute($name, $value);
}

$knihy = makeChild($doc, 'knihy'); // root

$kniha = makeChild($knihy, 'kniha');
addAttr($kniha, 'lang', 'cs');

makeChild($kniha, 'nazev', 'Epos o Berygamešovi');
makeChild($kniha, 'autor', 'Jiří Fišer');

$postavy = makeChild($kniha, 'postavy');
makeChild($postavy, 'postava', 'Berygameš');
makeChild($postavy, 'postava', 'Škvorkidu');

// atd ...

header('Content-Type: application/xml');
echo $doc->saveXML()
?>
