# JavaScript + HTML DOM

### HTML DOM

Stromová struktura, vytvořená z HTML stránky, dále je ji možno manipulovat pomocí JS.
Je přístupná přes globální objekt `document` (`window.document`).
* [JavaScript HTML DOM](https://www.w3schools.com/js/js_htmldom.asp)
* [HTML DOM Documents](https://www.w3schools.com/jsref/dom_obj_document.asp)
* [JavaScript HTML DOM Document](https://www.w3schools.com/js/js_htmldom_document.asp)

Zpracování HTML stránky - je nutno počkat, až bude DOM hotov:
* [`1 - dom.html`](../../Projekty/JS%20Tutorial/www/html/HtmlDom/1%20-%20dom.html)

JS vyhledá elementy v DOM různým způsobem:
* [`2 - dom.html`](../../Projekty/JS%20Tutorial/www/html/HtmlDom/2%20-%20dom.html)

JS lze přidat přímo do elementu pro obsluhu událostí:
* [`3 - events.html`](../../Projekty/JS%20Tutorial/www/html/HtmlDom/3%20-%20elem.html)

Události lze také obsluhovat mimo element:
* [`4 - events.html`](../../Projekty/JS%20Tutorial/www/html/HtmlDom/3%20-%20elem.html)

### ❖ Úkol 9.1: Pexeso



### HTML + XML DOM + AJAX
* [JavaScript AJAX](https://www.w3schools.com/XML/ajax_intro.asp)

Z JS lze volat asynchronní HTTP požadavky ([AJAX](https://www.w3schools.com/xml/ajax_intro.asp)). AJAX je přístupný přes objekt (API) [XMLHttpRequest](https://www.w3schools.com/xml/xml_http.asp), nebo přes [JS Fetch API](https://www.w3schools.com/jsref/api_fetch.asp).

Ukázka manipulace DOM & JS & AJAX. Asynchronně získá data v XML, která použije pro HTML.
* [`6 - knihy.html`](../../Projekty/JS%20Tutorial/www/html/JavaScript/6%20-%20knihy.html)

### ❖ Úkol 8.1: DOM

Dokončete ukázku DOM & JS & AJAX:
* Zobrazte více dat z `knihy.xml` (např. v ostylované tabulce).
* Přidejte JS obsluhu různých událostí (`'click'`, `'dblclick'`, `'mouseover'`, `'keydown'`).
