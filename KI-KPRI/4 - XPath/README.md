# XPath

## Přístup k obsahu souborů na serveru pomocí PHP

Datové XML je možné na serveru umístit mimo přímý dosah Apache. (Ve skutečném (provozním) systému se také XML generuje za běhu z databázových dat.)

Takto lze obsah zvoleného souboru zveřejnit pomocí PHP funkce [readfile()](https://www.php.net/manual/en/function.readfile.php):

* [`6 - fakulta.php`](../Projekt%20-%20work/www/html/6%20-%20fakulta.php)

Častěji ale nejdříve přečteme obsah souboru, který pak upravený nebo filtrovaný odešleme na výstup:

* [`7 - fakulta.php`](../Projekt%20-%20work/www/html/7%20-%20fakulta.php)

XML soubor lze také (dokonce by se měl) nejdříve validovat a ostylovat:

* [`8 - fakulta.php`](../Projekt%20-%20work/www/html/8%20-%20fakulta.php)

Skutečný, produkční kód musí ošetřit možné chyby!

Velmi hrubé řešení je zde. Pokud cokoli selže, PHP skript se ukončí. Není to ideální řešení, ale alespoň se interní údaje nepošlou do prohlížeče. Pro vývoj a testování, samozřejmě, takové údaje potřebujeme, takže zachycení varování a chyb vypneme, a dovolíme, aby se v prohlížeči zobrazily.

* [`9 - fakulta.php`](../Projekt%20-%20work/www/html/9%20-%20fakulta.php)

## XSL, XPath: filtrování, řazení

Projděte si popis [XPath](https://www.w3schools.com/xml/xml_xpath.asp) a XPath [tutoriál](https://www.w3schools.com/xml/xpath_intro.asp).

Možná přijde vhod:
* [XPath Cheat Sheet](https://www.browserbear.com/blog/xpath-cheat-sheet-a-quick-reference-to-essential-xpath-expressions/#using-functions-in-an-xpath-expression)
* [XPath Cheat Sheet](https://devhints.io/xpath)
* [XPath Testbed](http://www.whitebeam.org/library/guide/TechNotes/xpathtestbed.rhtm)

### Příklady: Použijte XPath a XPath osy v XSL pro různé výstupy

Zde jsou různé XSL soubory, které transformují `studium.xsl` tak, že generují následující HTML nebo XML:


1. Seznam všech předmětů: kód + názvy předmětů, jako seznam s odrážkami nebo číslovaný seznam.
    * [`10 - studium-1.php`](../Projekt%20-%20work/www/html/10%20-%20studium-1.php)

1. Seznam předmětů upravte (ostylujte) tak, aby předměty vyučované různými katedrami měly různé pozadí (barvu).
    * [`10 - studium-2.php`](../Projekt%20-%20work/www/html/10%20-%20studium-2.php)

1. Tabulku předmětů v prvním roce studia, v zimním semestru. Sloupce tabulky obsahují: kód předmětu (např. *KI/PRI*), počet kreditů, vyučující, ... atd.
    * [`10 - studium-3.php`](../Projekt%20-%20work/www/html/10%20-%20studium-3.php)

1. Tabulku s údaji pro daný předmět (např. MRL).
    * [`10 - studium-4.php`](../Projekt%20-%20work/www/html/10%20-%20studium-4.php)

1. Seznam předmětů v posledním semestru:
    - v pořadí, v jakém jsou v XML souboru
    - seřazené podle kódu předmětu
    - seřazené podle počtu kreditů
    - pod tabulku uveďte „Celkem kreditních bodů = ...“.
    * [`10 - studium-5.php`](../Projekt%20-%20work/www/html/10%20-%20studium-5.php)

1. Tabulku předmětů podle semestrů, pouze předměty s počtem kreditů > 2.
    * [`10 - studium-6.php`](../Projekt%20-%20work/www/html/10%20-%20studium-6.php)

1. Seznam semestrů podle celkového počtu kreditních bodů.
    * [`10 - studium-7.php`](../Projekt%20-%20work/www/html/10%20-%20studium-7.php)

1. Seznam předmětů v prvním semestru. Předměty, které vyučují různé katedry, mají mít různé pozadí (barvu).
    * [`10 - studium-8.php`](../Projekt%20-%20work/www/html/10%20-%20studium-8.php)

1. Seznam předmětů pro semestr s nejvyšším celkovým počtem kreditů.
    * [`10 - studium-9.php`](../Projekt%20-%20work/www/html/10%20-%20studium-9.php)

Řešení nejsou samozřejmě jediná možná. Jsou také jen nastíněná a potřebují dokončit tak, aby jejich výstupem bylo buď validní HTML nebo XML.

