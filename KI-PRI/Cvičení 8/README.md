# JavaScript v HTML

[JavaScript](https://en.wikipedia.org/wiki/JavaScript) je „programovací jazyk pro web“. Oficiální název je [ECMAScript](https://www.w3schools.com/Js/js_versions.asp) (ES). Verze ES6 v roce 2015 představovala podstatnou revizi ES. Následovala verze ES7 (2016)
a novější verze jsou jedoduše označeny letopočtem (2016+).

Současná verze je [ES2023](https://ecma-international.org/publications-and-standards/standards/ecma-262/).

Prohlížeče obsahují "runtime environment" (JavaScript Engine) pro ES. Ten JavaScript *interpretuje* a také může požít [JIT kompilaci](https://en.wikipedia.org/wiki/Just-in-time_compilation). Prohlížeče založené na [Chromium](https://en.wikipedia.org/wiki/Chromium_(web_browser)) používají [V8](https://en.wikipedia.org/wiki/V8_(JavaScript_engine)).

JavaScript může běžet i mimo prohlížeč, např. na serveru, v [Node.js](https://nodejs.org/) nebo v [Deno](https://deno.com/). [TypeScript](https://www.typescriptlang.org/) pak udělal z JavaScriptu plně moderní programovací jazyk, pro běžné, *nekritické* aplikace.

Různé prohlížeče sledují [vývoj ECMA různě](https://compat-table.github.io/compat-table/es2016plus/). Totéž platí pro stále se vyvíjející HTML, CSS a JS API: [Can I use...?](https://caniuse.com/)

Při profesionálním vývoji JS softwaru se používá [transpilace a polyfills](https://caniuse.com/), která řeší mj. nekompatibilitu moderní JS verze s verzí podporovanou příslušným prohlížečem.

JS v prohlížeči má přístup k DOM a může jej měnit. Tak je možné např. implementovat SPA - Single Page Applications. Příklad: [fabrika.kestolu.cz](https://fabrika.kestolu.cz/).

# [JS Tutorial](https://www.w3schools.com/js/default.asp)

Dnes nepotřebujeme Docker web server, stačí jednoduché .html soubory: [JS Tutorial](../Projekty/JS%20Tutorial).

## [jak vložit JS do stránky](https://www.w3schools.com/Js/js_whereto.asp)
Pomocí značky `<script>` (dříve: `<script type="text/javascript">` - dnes není nutné specifikovat *type*)

* [1 - whereto.html](../Projekty/JS%20Tutorial/1%20-%20whereto.html)
* [1 - whereto.xml](../Projekty/JS%20Tutorial/1%20-%20whereto.xml)
* [1 - whereto-xsl.xml](../Projekty/JS%20Tutorial/1%20-%20whereto-xsl.xml) (nejde jako file://)

## [Output](https://www.w3schools.com/Js/js_output.asp)

Metody a vlastnosti (methods, properties) globálního objektu [window](https://www.w3schools.com/jsref/obj_window.asp) (`window.` není nutné psát)
* [alert()](https://www.w3schools.com/jsref/met_win_alert.asp)
* [console](https://www.w3schools.com/jsref/prop_win_console.asp)

## [Příkazy](https://www.w3schools.com/Js/js_statements.asp)

Středníky odddělují příkazy - na konci řádky jsou nepovinné.

## [Syntax](https://www.w3schools.com/Js/js_syntax.asp)

## [Komentáře](https://www.w3schools.com/Js/js_comments.asp)

## [Proměnné](https://www.w3schools.com/Js/js_variables.asp)

Proměnné jsou "hoisted"! `let` proměnné nelze použít před inicializací, `const` musí být inicializované.

* [2 - variables.html](../Projekty/JS%20Tutorial/2%20-%20variables.html)

## [Operátory](https://www.w3schools.com/Js/js_operators.asp)

## [Datové typy](https://www.w3schools.com/Js/js_datatypes.asp)

## [Funkce](https://www.w3schools.com/Js/js_functions.asp)

Standardní, anonymní, šipková notace.

* [3 - functions.html](../Projekty/JS%20Tutorial/3%20-%20functions.html)

## [Řetězce](https://www.w3schools.com/Js/js_strings.asp)

* <code>'...'</code>
* <code>"..."</code>
* <code>`...`</code> template strings

* [4 - strings.html](../Projekty/JS%20Tutorial/4%20-%20strings.html)

## Další

* [pole](https://www.w3schools.com/Js/js_arrays.asp)
* [if-else](https://www.w3schools.com/Js/js_if_else.asp)
* [switch](https://www.w3schools.com/Js/js_switch.asp)
* [for](https://www.w3schools.com/Js/js_loop_for.asp)
* [objekty](https://www.w3schools.com/Js/js_objects.asp)
* [for in](https://www.w3schools.com/Js/js_loop_forin.asp)
* [for of](https://www.w3schools.com/Js/js_loop_forof.asp)

## HTML a XML DOM

* [JavaScript HTML DOM](https://www.w3schools.com/js/js_htmldom.asp)
* [JavaScript XML DOM](https://www.w3schools.com/XML/dom_intro.asp)
* [JavaScript AJAX](https://www.w3schools.com/XML/ajax_intro.asp)

* [document](https://www.w3schools.com/js/js_htmldom_document.asp) ...
* [5 - document.html](../Projekty/JS%20Tutorial/5%20-%20document.html)

* [Docker: dom](../Projekty/JS%20Tutorial/dom)


