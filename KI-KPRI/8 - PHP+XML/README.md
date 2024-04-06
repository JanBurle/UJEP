# SimpleXML

XML data lze manipulovat pomocí SimpleXML.

## Čtení XML pomocí SimpleXML

[SimpleXML](https://www.w3schools.com/Php/php_ref_simplexml.asp) (také [zde](https://www.php.net/manual/en/book.simplexml.php)) je rozšíření PHP pomocí kterého se snadno manipulují XML data.

### Načtení XML do SimpleXML objektu

Ze souboru pomocí [simplexml_load_file()](https://www.w3schools.com/Php/func_simplexml_load_file.asp):

* `SimpleXML/simplexml-load-file.php`

Z textu pomocí [simplexml_load_string()](https://www.w3schools.com/Php/func_simplexml_load_string.asp):

* `SimpleXML/simplexml-load-string.php`

Tento příklad používá tzv. [heredoc](https://www.phptutorial.net/php-tutorial/php-heredoc/) syntax.

## Navigace v SimpleXML

Každý uzel v SimpleXML stromu je instance PHP třídy [SimpleXMLElement](https://www.php.net/manual/en/class.simplexmlelement.php). Pomocí metod této třídy lze např. celý strom rekurzivně projít:

* `SimpleXML/simplexml-iterate1.php`

Pokud znáte strukturu vašeho SimpleXML (soubor XML je validní), můžete přímo přistoupit k jeho částem:

* `SimpleXML/simplexml-iterate2.php`

Můžete také použít [xpath](https://www.php.net/manual/en/simplexmlelement.xpath.php):

* `SimpleXML/simplexml-iterate3.php`

## Vytvoření XML pomocí SimpleXML

V SimpleXML lze vytvořit stromovou strukturu, a tu pak např. vyexportovat jako well-structured XML text:

* `SimpleXML/simplexml-create.php`

Pokud chcete, aby XML text obsahoval styl, použijte:

* `SimpleXML/simplexml-create-xsl.php`

HTTP header `Content-Type` je pokyn prohlížeči, aby stránku interpretoval jako XML, včetně stylu.

## Čtení dat z databáze a generování XML

V databázi jsou testovací data. Lze z nich dynamicky vygenerovat přehled fakult, kateder atd.:

* `SimpleXML/simplexml-create-db.php`
