# JavaScript + XML DOM

Dnes:
1. JS + XML DOM
2. JS + SVG

## XML DOM v HTML stránce

Datové ostrůvky XML ([XML Data Islands](https://learn.microsoft.com/en-us/previous-versions/windows/desktop/ms766512(v=vs.85))) o s nimi spojený DSO (Data Source Object) pro vkládání XML dat do HTML stránek bylo specifické řešení Microsoftu v prohlížeči Internet Explorer. Dnes již [nejsou podporovány](https://learn.microsoft.com/en-us/previous-versions/windows/internet-explorer/ie-developer/compatibility/hh801224(v=vs.85)).

### Zdroj XML dat

XML data lze přímo vložit do stránky (místo datového ostrůvku) jako tzv. [datový blok](https://stackoverflow.com/questions/18748571/workaround-for-xml-data-islands/21986537#21986537)

* [`1 - xml data block.html`](../../Projekty/JS%20tutorial/www/html/XmlDom/1%20-%20xml%20data%20block.html)

Dnešní standardní přístup je ale XML data vyžádat pomocí [AJAX - XHR](https://www.w3schools.com/XML/ajax_intro.asp):

* [`2 - xml XHR.html`](../../Projekty/JS%20tutorial/www/html/XmlDom/2%20-%20xml%20XHR.html)

Nebo pomocí [JS Fetch API](https://www.w3schools.com/jsref/api_fetch.asp):

* [`3 - xml fetch.html`](../../Projekty/JS%20tutorial/www/html/XmlDom/3%20-%20xml%20fetch.html)

### Konverze na XML DOM

Přijatá XML data je potřeba konvertovat na XML DOM, se který pak lze dále pracovat JavaScriptem. XHR má konverzi zabudovanou; při použití Fetch je nutno data [konvertovat explicitně](https://www.w3schools.com/xml/xml_parser.asp):

* [`ajax.js`](../../Projekty/JS%20tutorial/www/html/XmlDom/js/ajax.js)

### JavaScript XML DOM

[XML DOM Tutorial](https://www.w3schools.com/XML/dom_intro.asp):

XML DOM je v mnohém podobný HTML DOM.\
Vše je instance [uzlu](https://www.w3schools.com/XML/dom_nodes.asp). Uzly mohou být: element, text, atribut, komentář.\
Celý XML dokument je dokumentní uzel.\
Každý uzel má vlastnosti: [nodeName, nodeValue, nodeType](https://www.w3schools.com/XML/dom_nodes_info.asp)\
Uzel může mít [childNodes](https://www.w3schools.com/XML/dom_nodes_traverse.asp)

* [`4 - xml DOM.html`](../../Projekty/JS%20tutorial/www/html/XmlDom/4%20-%20xml%20DOM.html)

Po XML DOM se lze [pohybovat](https://www.w3schools.com/XML/dom_nodes_navigate.asp) pomocí: `parentNode`, `childNodes`, `firstChild`, `lastChild`, `nextSibling`, `previousSibling`.

Uzly lze: [měnit](https://www.w3schools.com/XML/dom_nodes_set.asp), [odebírat](https://www.w3schools.com/XML/dom_nodes_remove.asp), [zaměnit](https://www.w3schools.com/XML/dom_nodes_replace.asp), [přidávat](https://www.w3schools.com/XML/dom_nodes_create.asp), atd.

Většinou ale budeme XML DOM číst a HTML DOM manipulovat:

* [`5 - knihy.html`](../../Projekty/JS%20tutorial/www/html/XmlDom/5%20-%20knihy.html)

Další příklady manipulace DOM:

* [`Další příklady`](../../Projekty/JS%20tutorial/www/html/XmlDom/Další%20příklady)

### ❖ Úkol 10.1: DOM

Dokončete ukázku `5 - knihy.html`:
* Zobrazte více dat z XML souboru, a to např. v ostylované tabulce.
* Přidejte JS obsluhu dalších událostí: `click`, `dblclick`, `mouseover` ...

## SVG – Scalable Vector Graphics

[SVG](https://www.w3schools.com/graphics/svg_intro.asp) je vektorová grafika ve formátu XML.

* [`6 - svg hodiny.html`](../../Projekty/JS%20tutorial/www/html/XmlDom/6%20-%20svg%20hodiny.html)

### ❖ Úkol 10.2: DOM

Dokončete hodiny. Např:
* přidejte další ručičky
* hodiny ostylujte (CSS)
* přidejte obsluhu událostí: např. klik myší hodiny zastaví a další znovu spustí

Pro pokročilé: [dragging](https://www.petercollingridge.co.uk/tutorials/svg/interactive/dragging/)
