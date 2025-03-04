# JavaScript v HTML

[JavaScript](https://en.wikipedia.org/wiki/JavaScript) (JS) je „programovací jazyk pro web“.
Odpovídá [ECMAScript](https://www.w3schools.com/Js/js_versions.asp) (ES) standardu. Verze
ES6 v roce 2015 představovala podstatnou revizi ES. Následovala verze ES7 (2016) a novější
verze jsou jedoduše označeny letopočtem (2016+).

Současná verze je
[ES2023](https://ecma-international.org/publications-and-standards/standards/ecma-262/).

Prohlížeče obsahují "runtime environment" (JavaScript Engine). Ten JavaScript _interpretuje_
a také může požít [JIT kompilaci](https://en.wikipedia.org/wiki/Just-in-time_compilation).
Prohlížeče založené na [Chromium](<https://en.wikipedia.org/wiki/Chromium_(web_browser)>)
používají [V8](<https://en.wikipedia.org/wiki/V8_(JavaScript_engine)>).

JavaScript může běžet i mimo prohlížeč, např. jako desktopová aplikace nebo na webovém
serveru, v [Node.js](https://nodejs.org/) nebo v [Deno](https://deno.com/).
[TypeScript](https://www.typescriptlang.org/) pak udělal z JavaScriptu plně moderní
programovací jazyk, pro běžné, _nekritické_ aplikace.

V prohlížeči má JS přístup k různým
[WEB API](https://developer.mozilla.org/en-US/docs/Web/API) (mj. DOM).

Různé prohlížeče sledují
[vývoj ECMA různě](https://compat-table.github.io/compat-table/es2016plus/). Totéž platí pro
stále se vyvíjející HTML, CSS a JS API: [Can I use...?](https://caniuse.com/)

Při profesionálním vývoji JS softwaru se používá
[transpilace a polyfills](https://javascript.info/polyfills), které také řeší
nekompatibilitu moderní JS verze s verzí podporovanou příslušným prohlížečem.

JS v prohlížeči má přístup k DOM a může jej měnit. Tak je možné např. implementovat SPA -
Single Page Applications. Příklad: [fabrika.kestolu.cz](https://fabrika.kestolu.cz/).

# JS Tutorial

[JavaScript Tutorial](https://www.w3schools.com/js/default.asp)

Příklady na této stránce běží v [projektu JS Tutorial](../../Projekty/JS%20tutorial). V
prohlížeči si otevřete vývojové nástroje (`Ctrl+Shift+I`) / Console.

## Jak vložit JS do stránky

[Jak vložit JS do stránky](https://www.w3schools.com/Js/js_whereto.asp)

JS se do stránky vloží značkou `<script>` (dříve muselo být:
`<script type="text/javascript">` - dnes není nutné _type_ specifikovat, `text/javascript`
je default).

JS v HTML:

- [`1a - whereto.html`](../../Projekty/JS%20tutorial/html/JavaScript/1a%20-%20whereto.html)

JS v XML:

- [`1b - whereto.xml`](../../Projekty/JS%20tutorial/html/JavaScript/1b%20-%20whereto.xml)

JS v transformovaném XML:

- [`1c - whereto-xsl.xml`](../../Projekty/JS%20tutorial/html/JavaScript/1c%20-%20whereto-xsl.xml)

## JS Output

[JavaScript Output](https://www.w3schools.com/Js/js_output.asp)

- [alert()](https://www.w3schools.com/jsref/met_win_alert.asp)
- [console.log()](https://www.w3schools.com/jsref/prop_win_console.asp) (log() a další
  metody)

`alert` a `console` patří do globálního objektu
[window](https://www.w3schools.com/jsref/obj_window.asp), který reprezentuje záložku
prohlížeče.

Protože skripty v HTML/XML stránce běží v globálním kontextu objektu `window`, není potřeba
u metod a vlastností (properties) není potřeba psát `window.`

- [`2 - output.html`](../../Projekty/JS%20tutorial/html/JavaScript/1c%20-%20output.html)

## Příkazy

[Příkazy](https://www.w3schools.com/Js/js_statements.asp)

Příkazy jsou oddělené středníky. Středníky na konci řádky jsou nepovinné. Existují dvě
školy: 1) středníky všude, kde je možné, 2) jen tam, kde jsou nutné

## Syntax

[Syntax](https://www.w3schools.com/Js/js_syntax.asp)

## Komentáře

[Komentáře](https://www.w3schools.com/Js/js_comments.asp)

## Proměnné

[Proměnné](https://www.w3schools.com/Js/js_variables.asp)

Deklarace proměnných jsou ["hoisted"](https://www.w3schools.com/js/js_hoisting.asp)! `let`
proměnné nelze použít před inicializací, `const` musí být inicializované.

- [`3 - variables.html`](../../Projekty/JS%20tutorial/html/JavaScript/2%20-%20variables.html)

## Operátory

[Operátory](https://www.w3schools.com/Js/js_operators.asp)

## Datové typy

[Datové typy](https://www.w3schools.com/Js/js_datatypes.asp)

## Funkce

[Funkce](https://www.w3schools.com/Js/js_functions.asp)

Standardní, anonymní, šipková notace.

- [`4 - functions.html`](../../Projekty/JS%20tutorial/html/JavaScript/3%20-%20functions.html)

## Řetězce

[Řetězce](https://www.w3schools.com/Js/js_strings.asp)

- `'...'`
- `"..."`
- <code>\`...\`</code> template strings, s expanzí (substitucí) proměnných

- [`5 - strings.html`](../../Projekty/JS%20tutorial/html/JavaScript/4%20-%20strings.html)

## Další

- [pole](https://www.w3schools.com/Js/js_arrays.asp)
- [if-else](https://www.w3schools.com/Js/js_if_else.asp)
- [switch](https://www.w3schools.com/Js/js_switch.asp)
- [for](https://www.w3schools.com/Js/js_loop_for.asp)
- [objekty](https://www.w3schools.com/Js/js_objects.asp)
- [for in](https://www.w3schools.com/Js/js_loop_forin.asp)
- [for of](https://www.w3schools.com/Js/js_loop_forof.asp)
