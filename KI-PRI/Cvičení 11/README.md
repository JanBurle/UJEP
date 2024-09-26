# PHP + XML, sessions, cookies

Dnes:
1. PHP + XML DOM
1. PHP + cookies
1. PHP session
1. Vylepšené hodiny (code walkthrough)

## PHP + XML DOM

Existují různé [XML parsery](https://www.w3schools.com/php/php_xml_parsers.asp), které v PHP načtou XML a vytvoří DOM:
* parsery, které načtou celý soubor a vytvoří celý DOM strom:
    * SimpleXML – viz [Cvičení 5](../Cvi%C4%8Den%C3%AD%205/README.md).
    * **XML DOM parser** (dnes standardní součást PHP)
* parsery, které čtou ze soubory uzly sériově – pro zpracování rozsáhlých dat

## PHP XML DOM parser

Implementovaný PHP třídou [DOMDocument](https://www.php.net/manual/en/class.domdocument.php).

Metody pro načtení a uložení dat:
* [load()](https://www.php.net/manual/en/domdocument.load.php) ze souboru
* [loadXML()](https://www.php.net/manual/en/domdocument.loadxml.php) z řetězce
* [saveXML()](https://www.php.net/manual/en/domdocument.savexml.php) jako řetězec

Příklady použití DOM:
* načtení ze souboru: [1 - load.php](../Projekt%2011/www/html/phpxmldom/1%20-%20load.php)
* načtení z řetězce: [2 - load XML.php](../Projekt%2011/www/html/phpxmldom/2%20-%20load%20XML.php)
* procházení stromem: [3 - looping.php](../Projekt%2011/www/html/phpxmldom/3%20-%20looping.php)
* rekurzivní výpis: [4 - tree.php](../Projekt%2011/www/html/phpxmldom/4%20-%20tree.php)
* přístup k datům: [5 - get.php](../Projekt%2011/www/html/phpxmldom/5%20-%20get.php)
* sestavit XML: [6 - create.php](../Projekt%2011/www/html/phpxmldom/6%20-%20create.php)

## Keksy – sušenky – cookies

HTTP je bezstavový (stateless) protokol. HTTP požadavek musí obsahovat všechny nutné informace pro jeho zpracování (poteciálně mnoho). Situaci lze řešit tím, že stavové informace (paměť) se ukládají na serveru jako data sezení (session data) a sezení se identifikuje pomocí identifikátoru (session id – SID). Klient a server si pak SID předávají při každém požadavku.

## Cookies

(1994, Netscape)

Krátká textová data (HTTP je textový protokol), které si klient (prohlížeč) a webová server automaticky vyměnují v HTTP *hlavičce*: `Set-Cookie: ...`

Jednoduchý stav lze ukládat přímo v cookies, ale s potenciálními problémy: velikost dat, blokování cookies v prohlížeči, a také  mj. [EU Cookie Compliance](https://gdpr.eu/cookies/) (netýká se session cookies).

#### Cookies v PHP na serveru

* čtení: superglobální asociativní pole [$_COOKIE](https://www.php.net/manual/en/reserved.variables.cookies.php)
* nastavení/odesílání: [setcookie()](https://www.php.net/manual/en/function.setcookie.php)

#### Cookies v JS / HTML stránce

* čtení/nastavení: [document.cookie](https://www.w3schools.com/js/js_cookies.asp)

### Inspekce cookies (HTTP Headers) v prohlížeči

*DevTools (Inspect)*: *Network*, pod *Name* vyberte objekt, *Headers*.

Příklady:

* komunikace bez cookies: [1 - no cookie.php](../Projekt%2011/www/html/cookies/1%20-%20no%20cookie.php)
* JavaScript vytvoří cookie: [2 - JS set cookie.php](../Projekt%2011/www/html/cookies/2%20-%20JS%20set%20cookie.php)
* PHP vytvoří cookie: [3 - PHP set cookie.php](../Projekt%2011/www/html/cookies/3%20-%20PHP%20set%20cookie.php)

A nyní se posílají cookies i v (1), dokud druhé cookie neexpiruje.

#### Jednoduché použití cookie pro počítání zobrazení stránky

* [4 - PHP+JS cookie.php](../Projekt%2011/www/html/cookies/4%20-%20PHP+JS%20cookie.php)

## Sessions

V sezení lze ukládat stavová data, která lze použít v různých stránkách, nebo při obnově současné stránky. Klient a server si předávají unikátní identifikátor sezení (SID, session id).

SID lze předávat:
* v URL (HTTP GET parametr), např `?sid=...`
* v HTTP hlavičce, např. `X-SID=...`
* v HTTP POST datech
* v cookie
* a jinak :)

Data na serveru lze ukládat
* v dočasných souborech
* ve (sdílené) paměti
* v databázi
* jinak :)

Mechanismus sezení v PHP lze uživatelsky [konfigurovat](https://www.php.net/manual/en/session.configuration.php).

[PHP sessions](https://www.w3schools.com/php/php_sessions.asp) standardně používají cookies a dočasné soubory:

* [5 - PHP session cookie.php](../Projekt%2011/www/html/cookies/5%20-%20PHP%20session%20cookie.php)

Sezení se inicializuje pomocí [session_start()](https://www.php.net/manual/en/function.session-start.php), SID lze číst/nastavit [session_id()]([session_id().](https://www.php.net/manual/en/function.session-id.php)).

Dočasné soubory jsou na Linuxovém serveru v `/tmp`. Cookie `PHPSESSID` server generuje podle potřeby.

### Vícestránkový příklad

Několik stránek, přepínání pomocí:

* [cookies](../Projekt%2011/www/html/multipage/index-cookies.php)
* [session](../Projekt%2011/www/html/multipage/index-session.php)

## SVG hodiny

Z minulého cvičení, vylepšené:

* [`7 - lepší svg hodiny.html`](../../Projekty/JS%20tutorial/www/html/XmlDom/7%20-%20lepší%20svg%20hodiny.html)
