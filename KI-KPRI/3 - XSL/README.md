# Zobrazení XML pomocí CSS a XSLT

## HTML, XHTML

Zdrojový kód většiny webových stránek je psaný ve značkovacím jazyce (markup language), typicky v nějaké verzi HTML (dnes: HTML5) nebo XHTML. Panuje jistý chaos v tom, co je co, také proto, že celý webový „ekosystém“ je poznamenán svým bouřlivého vývojem a s ním spojenými [„válkami prohlížečů“](https://en.wikipedia.org/wiki/Browser_wars).

Protože mnoho (většina?) webových stránek obsahuje chyby, prohlížeče mají snahu chyby tolerovat a opravovat.

Jisté vysvětlení rozdílů mezi těmito značkovacími jazyky naleznete např. [zde](https://www.w3schools.com/Html/html_xhtml.asp) nebo [zde](https://hackr.io/blog/difference-between-html-html5-xhtml).

Připomeňte si, jaké možnosti [HTML](https://www.w3schools.com/html/default.asp) má.

Validitu různých formátů lze ověřit např. [W3 validátorem](https://validator.w3.org/).

### Příklad: validace webové stránky

Pomocí W3 validátoru ověřte validitu zdrojového kódu webových stránek, např.
* bing.com
* ujep.cz
* HTML kód našeho validátoru

## Zobrazení XML v prohlížeči

Pokud nemá XML soubor příslušnou informaci o stylu, zobrazí jej prohlížeč jako stromovou strukturu.

* `3 - cdcatalog.php`

## CSS – kaskádové styly

Kaskádové styly nejsou součástí našeho kurzu, měli byste však mít o nich základní znalosti.

Připomeňte si, jak [CSS přidat do HTML](https://www.w3schools.com/html/html_css.asp) (tři způsoby: inline, vnitřní, vnější). Plný manuál CSS je např. [zde](https://www.w3schools.com/cssref). Připomeňte si, mimo jiné, [CSS selektory](https://www.w3schools.com/cssref/css_selectors.php).

### Příklad: ostylujte XML pomocí CSS

Do XML souboru přidejte řádku specifikace CSS stylu:
```xml
<?xml-stylesheet type="text/css" href="....css"?>
```
V příslušném adresáři vytvořte odpovídající CSS soubor(y).

* `cdcatalog.css`

Zobrazte výsledek. Styl upravte a doplňte podle potřeby.

## Seznámení s XSLT a XPath

Validovaná XML data lze transformovat na HTML pomocí jazyka XSLT (eXtensible Stylesheet Language Transformations). Příklad XSLT naleznete na [XML XSLT](https://w3schools.com/xml/xml_xslt.asp) a tutoriál na [XSLT Introduction](https://www.w3schools.com/xml/xsl_intro.asp).

Pro navigaci v XML dokumentu v XSLT slouží jeho komponent [XPath](https://www.w3schools.com/xml/xml_xpath.asp). Tutoriál je na [XPath Tutorial](https://www.w3schools.com/xml/xpath_intro.asp).

## Převod XML do HTML pomocí XSLT

Ukázka transformace z XML na HTML je na stránce [XSLT Transformation](https://w3schools.com/xml/xsl_transformation.asp). Transformace se zde provádí pomocí XSLT elementů:
* [xsl:template](https://www.w3schools.com/xml/xsl_templates.asp) (šablona)
* [xsl:for-each](https://www.w3schools.com/xml/xsl_for_each.asp)
* [xsl:value-of](https://www.w3schools.com/xml/xsl_value_of.asp)

### Podmínky a cykly v XSLT

V jazyce XSLT lze využívat podmínky a cykly, které řídí, na které uzly a jak aplikovat pravidla v šabloně, pomocí následujících elementů:
* [xsl:value-of](https://w3schools.com/xml/xsl_value_of.asp) - získá data z jednoho uzlu a využije je při transformaci
* [xsl:for-each](https://w3schools.com/xml/xsl_for_each.asp) - realizace cyklu v XSLT z vyfiltrovaného výběru XML uzlů
* [xsl:sort](https://w3schools.com/xml/xsl_sort.asp) - slouží pro seřazení uzlů
* [xsl:if](https://w3schools.com/xml/xsl_if.asp) - slouží jako realizace podmínky v XSLT
* [xsl:choose](https://w3schools.com/xml/xsl_choose.asp) - realizace přepínače v XSLT

### Využití XPath v XSLT

Jazykem XPath volíte v XSL uzly nebo množiny uzlů. Projděte si [XPath Tutorial](https://www.w3schools.com/xml/xpath_intro.asp):
* uzly
* syntax (+ predikáty)
* osy
* operátory
* příklady

### Zobrazení XML pomocí XSLT

XML můžeme transformovat pomocí XSLT třemi způsoby:
* ponechat transformaci na prohlížeči
* transformovat na serveru (server-side) pomocí např. PHP
* transformovat na klientu (client-side) pomocí např. JavaScriptu

### Příklad: zobrazení XML/XSL v prohlížeči

Do XML souboru (student, fakulta) přidejte řádku specifikace XSL stylu:
```xml
<?xml-stylesheet type="text/xsl" href="....xsl"?>
```

* `cdcatalog.xsl`

Zobrazte výsledek. Styl upravte a doplňte podle potřeby.

### Příklad: transformace XML/XSL server-side

Proces je popsán v [XSLT - On the Server](https://www.w3schools.com/xml/xsl_server.asp).

Jednoduchý PHP skript, který provede transformaci, je zde:
* `4 - cdcatalog.php`

## Transformace XML/XSL client-side

* `5 - cdcatalog.php`

#### Otázka: jak do výstupu vložit mezeru?
Nezlomitelnou mezeru (non-breakable space):
* Jako desítkový UTF kód: `&#160;`
* Jako šestnáctkový UTF kód: `&#xA0;`

Obyčejnou mezeru také takto:
* `<xsl:text> </xsl:text>`

## Sémantické (významové) HTML

HTML5 obsahuje, kromě historických nesémantických značek/elementů, jako jsou `<div>`, `<span>` atd., elementy [sémantické](https://www.w3schools.com/html/html5_semantic_elements.asp): `<header>`, `<footer>`, `<main>`, ...

Ačkoli již na začátku 90. let, při divokém zrodu WWW a HTML, byli proponenti sémantiky v HTML, trvalo to dalších 15 let, než byly sémantické značky do HTML zavedeny.

Osvěžte si, jaké [značky HTML5](https://www.w3schools.com/tags/ref_byfunc.asp) obsahuje. Zde je [tutorál](https://www.freecodecamp.org/news/semantic-html5-elements/) k sémantickým elementům.

HTML5 také umožňuje vlastní, [uživatelské značky](https://www.tutsinsider.com/html/html-custom-tags/) (další [popis](https://matthewjamestaylor.com/custom-tags)). Takové značky je vhodné a především praktické vždy ostylovat (pomocí CSS), jinak se chovají jako `<div>`.
