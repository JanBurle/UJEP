# Cvičení 5 – SimpleXML

Dnes budete manipulovat XML data pomocí SimpleXML.

### Předchozí cvičení:

V předchozím cvičení jste vytvořili databázové tabulky pro vaše data o univerzitě, fakultách, studentech apod.

### Obsah tohoto cvičení:

* Inicializace databáze v Dockeru.
* Čtení XML pomocí SimpleXML.
* Navigace v SimpleXML objektu.
* Vytvoření XML pomocí SimpleXML.
* Čtení dat z databáze a generování XML.
* Stylování pomocí moderních CSS knihoven.

## Inicializace databáze v Dockeru

Ve složce *Projekt 5* naleznete dále pozměněnou kostru projektu.
* Kontejner *database* je nyní definován v dockerfile `Dockerfiles/Database`. V něm je přidán vnější SQL soubor `schema/univerzita.sql`, který inicializuje vždy, když je kontejner znovu sestaven.

### ❖ Úkol 5.1

Dokončete svůj model databázových tabulek. Velmi jednoduchý, nedokončený návrh pro inspiraci najdete v *Projektu 5*, vaše tabulky by ale měly odpovídat vašemu modelu, a být obsáhlejší.

Databázi exportujte do SQL a exportovaný SQL vložte do souboru, kterým budete inicializovat databázi v kontejneru.

## Čtení XML pomocí SimpleXML

[SimpleXML](https://www.w3schools.com/Php/php_ref_simplexml.asp) (také [zde](https://www.php.net/manual/en/book.simplexml.php)) je rozšíření PHP pomocí kterého se snadno manipulují XML data.

### Načtení XML do SimpleXML objektu

Ze souboru pomocí [simplexml_load_file()](https://www.w3schools.com/Php/func_simplexml_load_file.asp):
``` php
$xml = simplexml_load_file('xml/fakulta.xml');
print_r($xml);
```

Z textu pomocí [simplexml_load_string()](https://www.w3schools.com/Php/func_simplexml_load_string.asp):
``` php
$s = <<<HEREDOC
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="fakulta.xsl"?>
<fakulty>
  ...
</fakulty>
HEREDOC;

$xml = simplexml_load_string($s);
print_r($xml);
```
Tento příklad používá tzv. [heredoc](https://www.phptutorial.net/php-tutorial/php-heredoc/) syntax.

### ❖ Úkol 5.2

Načtěte vaše XML soubory do SimpleXML a pomocí [print_r()](https://www.php.net/manual/en/function.print-r.php) vypište SimpleXML strukturu. Porovnejte ji se zdrojovým XML.

## Navigace v SimpleXML
Každý uzel v SimpleXML stromu je instance PHP třídy [SimpleXMLElement](https://www.php.net/manual/en/class.simplexmlelement.php). Pomocí metod této třídy lze např. celý strom rekurzivně projít:
```php
$xml = simplexml_load_file('xml/fakulta.xml');

function traverseSimpleXML($xml, $level=0) {
    $space = fn($level) => str_repeat(' ', $level * 2);

    $attributes = $xml->attributes();

    foreach ($attributes as $name => $value) {
        echo $space($level) . "$name - " . (string)$value . "\n";
    }

    $children = $xml->children();
    foreach ($children as $name => $value) {
        if(0 < $value->count()) {
            echo $space($level) . "$name: \n";
            traverseSimpleXML($value, $level+1);
        } else {
            echo $space($level) . "$name = " . (string)$value . "\n";
        }
    }
}

traverseSimpleXML($xml);
```

Pokud znáte strukturu vašeho SimpleXML (soubor XML je validní), můžete přímo přistoupit k jeho částem:
```php
$xml = simplexml_load_file('xml/fakulta.xml');
echo (string)($xml->fakulta[0]->dekan->jmeno);
```

Můžete také použít [xpath](https://www.php.net/manual/en/simplexmlelement.xpath.php):
```php
$xml = simplexml_load_file('xml/fakulta.xml');
print_r($xml->xpath('/fakulty/fakulta[@id="Pri"]/dekan'));
```

### ❖ Úkol 5.3

Na vašech datech si vyzkoušejte procházení SimpleXML stromem, podobně jako ve výše uvedeném kódu, který podle potřeby rozšiřte pomocí dalších [SimpleXML funkcí](https://www.w3schools.com/Php/php_ref_simplexml.asp).

## Vytvoření XML pomocí SimpleXML

V SimpleXML lze vytvořit stromovou strukturu, a tu pak např. vyexportovat jako well-structured XML text:

```php
$xml = new SimpleXMLElement('<fakulta/>'); // kořen

$fakulta = $xml->addChild('fakulta');
$fakulta->addAttribute('id','Pri');

$dekan = $fakulta->addChild('dekan');
$dekan->addChild('jmeno','Michal');

header('Content-Type: application/xml');
echo $xml->asXML();
```

Pokud chcete, aby XML text obsahoval styl, použijte:
```php
$xml = new SimpleXMLElement('<?xml-stylesheet type="text/xsl" href="xml/fakulta.xsl"?><fakulta/>');
```

HTTP header `Content-Type` je pokyn prohlížeči, aby stránku interpretoval jako XML, včetně stylu.

### ❖ Úkol 5.4

Napište PHP skript, který pomocí SimpleXML vygeneruje XML, odpovídající vašemu `fakulta.xsd`.

## Čtení dat z databáze a generování XML

V databázi jsou testovací data. Lze z nich dynamicky vygenerovat přehled fakult, kateder atd.:

```php
$xml = new SimpleXMLElement('<?xml-stylesheet type="text/xsl" href="xml/fakulta.xsl"?><fakulty/>');
$db = mysqli_connect("database", "admin", "heslo", "univerzita");

$fakulty = $db->query('select id, nazev, dekan from Fakulta')->fetch_all();
foreach ($fakulty as [$id, $nazev, $idDekan]) {
    $fakulta = $xml->addChild('fakulta');
    if ($idDekan) {
        $dekan = $db->query("select jmeno, prijmeni, email from Osoba where id=$idDekan")->fetch_all();
        [$jmeno, $prijmeni, $email] = $dekan[0];

        $dekan = $fakulta->addChild('dekan');
        $dekan->addChild('jmeno',$jmeno);
        $dekan->addChild('prijmeni',$prijmeni);
        $dekan->addChild('email',$email);
    }
}

header('Content-Type: application/xml');
echo $xml->asXML();
```

### ❖ Úkol 5.5

Upravte váš skript z Úkolu 5.4 tak, aby data četl z databáze, a generoval validní XML odpovídající vašemu souboru `fakulta.xsd`.

## Stylování pomocí moderních CSS knihoven

Pokud jste došli až sem a zbývají vám síly :), stručně se seznamte s některou moderních CSS knihovnou (framework). V úvahu přicházejí, mimo jiné:

* [W3 CSS](https://www.w3schools.com/w3css)
* [Tailwind](https://tailwindcss.com/) ([wiki](https://en.wikipedia.org/wiki/Tailwind_CSS))
* [Bootstrap](https://getbootstrap.com/) ([wiki](https://en.wikipedia.org/wiki/Bootstrap_(front-end_framework)))

Najdete v nich mnoho připravených, vyladěných stylů a jejich kombinací pro vytváření responsivních webových stránek a aplikací.

### ❖ Úkol 5.6

Vyberte si jednu z uvedených CSS knihoven, nebo podobnou, a použijte ji ve vašem projektu, místo "vanilla" CSS.