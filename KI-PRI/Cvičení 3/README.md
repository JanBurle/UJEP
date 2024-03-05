# Cvičení 3 – Zobrazení XML pomocí CSS a XSLT

Dnes budete zobrazovat validní XML v prohlížeči.

### Předchozí cvičení:

V předchozím cvičení:
* Jste se seznámili s některými XML službami a formáty, jmenovitě se RSS.
* Well-formed XML jste dále validovali pomocí XSD.
* K vámi navrženým a vytvořeným XML souborům s daty o studentech a fakultách jste vytvořili validační DTD a XSD soubory.
* Upravili jste svůj webový server (v Dockeru) tak, aby validoval XML pomocí XSD.

### Obsah tohoto cvičení:

* Rychlá rekapitulace HTML, XHTML a CSS.
* Úprava webového serveru tak, aby zpřístupnil soubory z adresáře.
* Zobrazení XML v prohlížeči, ostylované pomocí CSS.
* Seznámení se XSLT a XPath.
* Zobrazení XML v prohlížeči pomocí XSLT, a to buď v klientu (client-side, v prohlížeči), nebo na serveru (server-side).

## HTML, XHTML

Zdrojový kód většiny webových stránek je psaný ve značkovacím jazyce (markup language), typicky v nějaké verzi HTML (dnes: HTML5) nebo XHTML. Panuje jistý chaos v tom, co je co, také proto, že celý webový „ekosystém“ je poznamenán svým bouřlivého vývojem a s ním spojenými [„válkami prohlížečů“](https://en.wikipedia.org/wiki/Browser_wars).

Protože mnoho (většina?) webových stránek obsahuje chyby, prohlížeče mají snahu chyby tolerovat a opravovat.

Jisté vysvětlení rozdílů mezi těmito značkovacími jazyky naleznete např. [zde](https://www.w3schools.com/Html/html_xhtml.asp) nebo [zde](https://hackr.io/blog/difference-between-html-html5-xhtml).

Připomeňte si, jaké možnosti [HTML](https://www.w3schools.com/html/default.asp) má.

Validitu různých formátů lze ověřit např. [W3 validátorem](https://validator.w3.org/).

### ❖ Úkol 3.1: validace webové stránky

Pomocí W3 validátoru ověřte validitu zdrojového kódu webových stránek, např.
* bing.com
* ujep.cz
* webovou stránku vašeho projektu z minulého cvičení

### ❖ Úkol 3.2: úprava webového serveru

Upravte svůj webový server tak, aby zpřístupnil soubory z disku. Inspirujte se přiloženým Projektem 3 (ten je ale dnes záměrně *nedokončený*).

V Projektu 3 jsou jako příklad soubory `cdcatalog.*`. Vy si ale do svého projektu vložte svoje soubory `student.*` a `fakulta.*`.

* Přesuňte adresář `xml` do `php/src`, aby soubory v něm byly přístupné přes URL.
* Přidejte do webové stránky odkazy na vaše XML soubory a ověřte, že se zobrazují v prohlížeči.

Soubor `cdcatalog.xml` (příklad, zkrácen):
```xml
<?xml version="1.0" encoding="UTF-8"?>
<catalog>
    <cd>
        <title>Empire Burlesque</title>
        <artist>Bob Dylan</artist>
        <country>USA</country>
        <company>Columbia</company>
        <price>10.90</price>
        <year>1985</year>
    </cd>
...
</catalog>
```

Do souboru `index.php` přidejte odkaz, příklad:
```php
  <a href='xml/cdcatalog.xml'>CD Catalog</a>
```
## CSS – kaskádové styly

Kaskádové styly nejsou součástí našeho kurzu, měli byste však mít o nich základní znalosti.

Připomeňte si, jak [CSS přidat do HTML](https://www.w3schools.com/html/html_css.asp) (tři způsoby: inline, vnitřní, vnější). Plný manuál CSS je např. [zde](https://www.w3schools.com/cssref). Připomeňte si, mimo jiné, [CSS selektory](https://www.w3schools.com/cssref/css_selectors.php).

## Zobrazení XML v prohlížeči, ostylované pomocí CSS

Bez informace o stylu zobrazí prohlížeč stromovou strukturu XML souboru.

### ❖ Úkol 3.3: ostylujte váš XML pomocí CSS

Do XML souboru (student, fakulta) přidejte řádku specifikace CSS stylu:
```xml
<?xml-stylesheet type="text/css" href="....css"?>
```
V příslušném adresáři vytvořte odpovídající CSS soubor(y).

Příklad: `cdcatalog.css`
```css
catalog {
  display: table;
  background-color: palegoldenrod;
  border: thin solid grey;
}

cd {
  display: table-row;
}

title, artist, country, company, price, year {
  display: table-cell;
}

price::before {
  content: '$';
}
```

Zobrazte výsledek. Styl upravte a doplňte podle potřeby.

## Seznámení s XSLT a XPath

Validovaná XML data lze transformovat na HTML pomocí jazyka XSLT (eXtensible Stylesheet Language Transformations). Příklad XSLT naleznete na [XML XSLT](https://w3schools.com/xml/xml_xslt.asp) a tutoriál na [XSLT Introduction](https://www.w3schools.com/xml/xsl_intro.asp).

Pro navigaci v XML dokumentu v XSLT slouží jeho komponent [XPath](https://www.w3schools.com/xml/xml_xpath.asp). Tutoriál je na [XPath Tutorial](https://www.w3schools.com/xml/xpath_intro.asp).

## Převod XML do HTML pomocí XSLT

Ukázka transformace z XML na HTML je na stránce [XSLT Transformation](https://w3schools.com/xml/xsl_transformation.asp). Transformace se zde provádí pomocí XSLT elementů:
* [xsl:template](https://www.w3schools.com/xml/xsl_templates.asp) (šablona)
* [xsl:for-each](https://www.w3schools.com/xml/xsl_for_each.asp)
* [xsl:value-of](https://www.w3schools.com/xml/xsl_value_of.asp)

Příklad: `cdcatalog.xsl`
```xml
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:template match="/">
    <html>
      <body>
        <h2>My CD Collection</h2>
        <table border="1">
          <tr bgcolor="#9acd32">
            <th style="text-align:left">Title</th>
            <th style="text-align:left">Artist</th>
          </tr>
          <xsl:for-each select="catalog/cd">
            <tr>
              <td>
                <xsl:value-of select="title"/>
              </td>
              <td>
                <xsl:value-of select="artist"/>
              </td>
            </tr>
          </xsl:for-each>
        </table>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
```
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

## Zobrazení XML pomocí XSLT

XML můžeme transformovat pomocí XSLT třemi způsoby:
* ponechat transformaci na prohlížeči
* transformovat na serveru (server-side) pomocí např. PHP
* transformovat na klientu (client-side) pomocí např. JavaScriptu

### ❖ Úkol 3.4: zobrazení XML/XSL v prohlížeči

Do XML souboru (student, fakulta) přidejte řádku specifikace XSL stylu:
```xml
<?xml-stylesheet type="text/xsl" href="....xsl"?>
```

V příslušném adresáři vytvořte odpovídající XSL soubor(y).

Příklad: `cdcatalog.xsl`
```xml
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:template match="/">
    <html>
      <body>
        <h2>My CD Collection</h2>
        <table border="1">
          <tr bgcolor="#9acd32">
            <th style="text-align:left">Title</th>
            <th style="text-align:left">Artist</th>
          </tr>
          <xsl:for-each select="catalog/cd">
            <tr>
              <td>
                <xsl:value-of select="title"/>
              </td>
              <td>
                <xsl:value-of select="artist"/>
              </td>
            </tr>
          </xsl:for-each>
        </table>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
```

Zobrazte výsledek. Styl upravte a doplňte podle potřeby.

### ❖ Úkol 3.5: transformace XML/XSL server-side

Proces je popsán v [XSLT - On the Server](https://www.w3schools.com/xml/xsl_server.asp).

Jednoduchý PHP skript, který provede transformaci, je zde:

```php
<!DOCTYPE html>
<html>

<body>
    <?php
    // XML
    $xml = new DOMDocument;
    $xml->load('xml/cdcatalog.xml');
    // XSL
    $xsl = new DOMDocument;
    $xsl->load('xml/cdcatalog.xsl');
    // transformer
    $xslt = new XSLTProcessor();
    $xslt->importStylesheet($xsl);
    $transformovany_xml = $xslt->transformToXml($xml);
    // output
    echo $transformovany_xml;
    ?>
</body>

</html>
```

Natvrdo zakódovaný (hard-coded) odkaz na XML soubor (`xml/cdcatalog.xml`) nahraďte odkazy na svoje student/fakulta soubory.

**Toto je samozřejmě jen hrubý prototyp.**

### ❖ Úkol 3.6: zdokonalení webového serveru

Pokuste se svůj PHP skript upravit tak, aby, např., dal na výběr k zobrazení XML soubory, které nalezne na disku (nápověda: `glob(...it)`). Zde máte volnou ruku – proveďte jakékoli úpravy, které uznáte za vhodné.

## Transformace XML/XSL client-side
Poněkud zastaralý příklad je [XSLT - On the Client](https://www.w3schools.com/xml/xsl_client.asp). Moderní kód by
* se již neměl muset starat o IE11 :)
* mohl použít [JavaScript Fetch API](https://www.w3schools.com/js/js_api_fetch.asp).

## Videa týdne

[Video 1](https://www.youtube.com/watch?v=Qhaz36TZG5Y) vysvětuje, co to je *responsive layout*, a CSS nástroje pro jeho psaní: *flexbox* a *grid*.
[Video 2](https://www.youtube.com/watch?v=ouncVBiye_M) představuje moderní alternativy, použitelné místo psaní „vanilla“ CSS kódu.
