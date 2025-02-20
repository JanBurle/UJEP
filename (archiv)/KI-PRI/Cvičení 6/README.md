# Cvičení 6 – XML, XSD, XSL, XPath

### Obsah tohoto cvičení:

- Vytvořit XSD k danému XML.
- Vytvořit XSL k danému XSD.
- Sémantické HTML.
- XSL, XPath: transformace, filtrování, řazení.

## Projekt 6

V dnešní verzi projektu není zahrnuta databáze, protože budeme pracovat jen s XML soubory a jednoduchým PHP kódem.

Původní mapování kořenového adresáře pro Apache `./html:/var/www/html` je posunuto o úroveň výše: je změněno na `./www:/var/www`[^1].
Máme tak možnost umístit na server soubory, které jsou mimo dosah Apache, ale je je stále možné číst v PHP kódu:

- `www/html` – zde jsou soubory, které jsou přístupné pro Apache, tedy pomocí URL v prohlížeči
- `www/xml` – zde jsou soubory, ke kterým lze přistoupit na serveru z PHP kódu, nikoli však přímo z prohlížeče

[^1]: [/var](https://www.linfo.org/var.html) je standardní adresář, do kterého systém zapisuje měnící se (*var*iable) data.

### ❖ Úkol 6.1 – ukázkové soubory

V adresáři `www/xml` naleznete ukázkové soubory `fakulta.*`. Pro stylování je použito [W3.CSS](https://www.w3schools.com/w3css/) a [Font Awesome](https://fontawesome.com/).
Prostudujte si tyto soubory a porovnejte s vaší verzí souborů `fakulta.*` a `student.*`. Posuďte je a proveďte nebo navrhněte úpravy, změny a vylepšení.

### Přístup k obsahu souborů na serveru

Nyní jsou naše datové XML soubory na serveru mimo přímý dosah. (Ve skutečném (provozním) systému se XML bude generovat z databázových dat.)

Takto lze obsah zvoleného souboru zveřejnit pomocí PHP funkce [readfile()](https://www.php.net/manual/en/function.readfile.php):

```php
header('Content-Type: application/xml');
readfile('../xml/fakulta.xml');
```

Častěji ale nejdříve přečteme obsah souboru, který pak upravený nebo filtrovaný odešleme na výstup:

```php
$xml = file_get_contents('../xml/fakulta.xml');
// nějaké zpracování ...
header('Content-Type: application/xml');
echo $xml;
```

XML soubor lze (dokonce by se měl) nejdříve validovat a ostylovat:

```php
<?php
$filenameBase = '../xml/fakulta';

$xmlFile = "$filenameBase.xml";
$xsdFile = "$filenameBase.xsd";
$xslFile = "$filenameBase.xsl";

$xml = new DOMDocument;
$xml->load($xmlFile);
$xml->schemaValidate($xsdFile);

$xsl = new DOMDocument;
$xsl->load($xslFile);

$xslt = new XSLTProcessor();
$xslt->importStylesheet($xsl);
$xml = $xslt->transformToXml($xml);

echo $xml;
```

**Skutečný, produkční kód musí ošetřit možné chyby!**
Velmi hrubé řešení naleznete v _Projekt 6_. Pokud cokoli selže, PHP skript se ukončí. Není to ideální řešení, ale alespoň se interní údaje nepošlou do prohlížeče. Pro vývoj a testování, samozřejmě, takové údaje potřebujeme, takže zachycení varování a chyb vypneme, a dovolíme, aby se v prohlížeči zobrazily.

## XSD

Připomeňte si základy XSD ze [Cvičení 2](../Cvi%C4%8Den%C3%AD%202/README.md).

### ❖ Úkol 6.2 – Vytvořit XSD k danému XML

V _Projektu 6_ je soubor `xml/studium.xml`, který zachycuje program studia – ročníky, semestry a předměty.

Nejdříve revidujte data v souboru a doplňte je o další údaje:

- přidejte do programu studia další předměty, také z jiných kateder
- rozšiřte element `<vyucujici>` o telefon a email

Poté vytvořte podle XML souboru XSD soubor `studium.xsd` pro validaci.

V XSD souboru použijte [datové typy](https://www.w3schools.com/xml/schema_dtypes_string.asp), [xs:simpleType](https://www.w3schools.com/xml/el_simpletype.asp) a [xs:restriction](https://www.w3schools.com/xml/el_restriction.asp), [xs:complexType](https://www.w3schools.com/xml/el_complextype.asp), [xs:sequence]() a další možnosti, které [XSD Schema](https://www.w3schools.com/xml/schema_intro.asp) nabízí.

Pokuste se o to, aby vaše XSD definice byla striktní a omezila obsah XML souboru na pokud možno co nejvíce validní data. Takový přístup je základem vytváření robustních softwarových systémů.

## XSL

Připomeňte si základy XSLT ze [Cvičení 3](../Cvi%C4%8Den%C3%AD%203/README.md).

### ❖ Úkol 6.3 – Vytvořit XSL k danému XSD

Podle svého souboru `studium.xsd` z úkolu 6.2 vytvořte `studium.xsl`, který transformuje XML na HTML5. ([XSLT](https://www.w3schools.com/xml/xsl_intro.asp))

#### Otázka: jak do výstupu vložit mezeru?

Nezlomitelnou mezeru (non-breakable space):

- Jako desítkový UTF kód: `&#160;`
- Jako šestnáctkový UTF kód: `&#xA0;`

Obyčejnou mezeru také takto:

- `<xsl:text> </xsl:text>`

## Sémantické (významové) HTML

HTML5 obsahuje, kromě historických nesémantických značek/elementů, jako jsou `<div>`, `<span>` atd., elementy [sémantické](https://www.w3schools.com/html/html5_semantic_elements.asp): `<header>`, `<footer>`, `<main>`, ...

Ačkoli již na začátku 90. let, při divokém zrodu WWW a HTML, byli proponenti sémantiky v HTML, trvalo to dalších 15 let, než byly sémantické značky do HTML zavedeny.

Osvěžte si, jaké [značky HTML5](https://www.w3schools.com/tags/ref_byfunc.asp) obsahuje. Zde je [tutorál](https://www.freecodecamp.org/news/semantic-html5-elements/) k sémantickým elementům.

HTML5 také umožňuje vlastní, [uživatelské značky](https://www.tutsinsider.com/html/html-custom-tags/) (další [popis](https://matthewjamestaylor.com/custom-tags)). Takové značky je vhodné a především praktické vždy ostylovat (pomocí CSS), jinak se chovají jako `<div>`.

### ❖ Úkol 6.4 – Upravte HTML (XSL) na sémantické elementy

Váš transformační soubor `studium.xsl` z úkolu 6.3 upravte tak, aby používal HTML5 sémantické elementy, pokud a kde je možné a vhodné. Případně použijte i vlastní uživatelské značky, např `<uni-studium>`, `<uni-rocnik>`, apod.

## XSL, XPath: filtrování, řazení

Projděte si znovu popis [XPath](https://www.w3schools.com/xml/xml_xpath.asp) a XPath [tutoriál](https://www.w3schools.com/xml/xpath_intro.asp).

Možná přijde vhod:

- [XPath Cheat Sheet](https://www.browserbear.com/blog/xpath-cheat-sheet-a-quick-reference-to-essential-xpath-expressions/#using-functions-in-an-xpath-expression)
- [XPath Cheat Sheet](https://devhints.io/xpath)
- [XPath Testbed](http://www.whitebeam.org/library/guide/TechNotes/xpathtestbed.rhtm)

### ❖ Úkol 6.5 – Použijte XPath a XPath osy v XSL pro různé výstupy

Vytvořte různé XSL soubory, které transformují `studium.xsl` tak, že generují následující HTML nebo XML:

1. Seznam všech předmětů: kód + názvy předmětů, jako seznam s odrážkami nebo číslovaný seznam.

1. Seznam předmětů upravte (ostylujte) tak, aby předměty vyučované různými katedrami měly různé pozadí (barvu).

1. Tabulku předmětů v prvním roce studia, v zimním semestru. Sloupce tabulky obsahují: kód předmětu (např. _KI/PRI_), počet kreditů, vyučující, ... atd.

1. Tabulku s údaji pro daný předmět (např. MRL).

1. Seznam předmětů v posledním semestru:

   - v pořadí, v jakém jsou v XML souboru
   - seřazené podle kódu předmětu
   - seřazené podle počtu kreditů
   - pod tabulku uveďte „Celkem kreditních bodů = ...“.

1. Tabulku předmětů podle semestrů, pouze předměty s počtem kreditů > 2.

1. Seznam semestrů podle celkového počtu kreditních bodů.

1. Seznam předmětů v prvním semestru. Předměty, které vyučují různé katedry, mají mít různé pozadí (barvu).

1. Seznam předmětů pro semestr s nejvyšším celkovým počtem kreditů.

### Příklad:

V _Projektu 6_ naleznete příklady transformačních XSL souborů pro problém 1:

- `studium-1-X.xsl`: transformace do HTML
- `studium-1-xml.xsl`: transformace do XML

### ❖ Další úlohy:

1. Uspořádejte seznam semestrů podle celkového počtu kursů, které se studují v tomto semestru.

1. Název a počet kreditů předmětu, který má největší počet kreditů ze všech předmětů v prvním semestru .

1. Název a kredity pro tři předměty, které mají největší počet kreditů ze všech předmětů.

1. Tabulka, která obsahuje právě jeden předmět z každého semestru, který má nejvyšší počet kreditů.

1. Seznam povinně volitelných a výběrových předmětů, uspořádané podle semestrů. Výběrové kursy mají odlišnou barvu.

1. Tabulka předmětů, které se studují mimo katedru informatiky.
