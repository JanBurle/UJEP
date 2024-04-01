# Cvičení 6 – XPath (řešení příkladů), základy PHP

### Obsah tohoto cvičení:

* Ukázková řešení příkladů z minulého cvičení.
* Základy PHP (přehled, letem-světem).
* HTML formuláře.
* HTTP post, get.

## XPath – řešení

V projektu [XPath - řešení](../XPath%20-%20%C5%99e%C5%A1en%C3%AD) naleznete ukázková řešení [XPath/XSLT problémů](../Cvi%C4%8Den%C3%AD%206#xsl-xpath-filtrov%C3%A1n%C3%AD-%C5%99azen%C3%AD) z minulého cvičení.[^1] 

Řešení nejsou samozřejmě jediná možná. Jsou také jen nastíněná, potřebují dokončit tak, aby jejich výstupem bylo buď validní HTML nebo XML.

V kořenovém adresáři `www/html` je soubor [.htaccess](https://httpd.apache.org/docs/current/howto/htaccess.html), ve kterém je povoleno, aby Apache generoval obsah adresáře. Nemusíme tak psát `index.php` (`index.html`).

[^1] Kredit: RŠ, MF.

### ❖ Úkol 7.1 – dokončete ukázkové řešení

Projděte si předložená řešení, porovnejte se svými. Vyberte si některá a dokončete příslušný XSL soubor tak, aby výstupem bylo buď validní HTML nebo XML.

## Základy PHP

[PHP](https://en.wikipedia.org/wiki/PHP) vzniklo před třiceti lety.

Podle dostupných údajů je dnes PHP použito až na 3/4 (?) aktivních webových stránek (server-side). Z nich polovina běží na PHP 7 (7.4, end-of-life), zbytek na PHP 8 (8.3) a "legacy" software na PHP 5 (5.4).

Kanonická dokumentace je na [php.net](https://www.php.net/). [Rozdíly mezi PHP 7 a 8](https://www.php.net/manual/en/migration80.php) nejsou zásadní a my se jimi zabývat nemusíme.

### IDE (Integrated Development Environment)

Pro profesionální práci, kdy se očekává vysoká produktivita, je vhodné profesionální IDE, např. [PhpStorm](https://www.jetbrains.com/phpstorm/https://www.jetbrains.com/phpstorm/).
Pro běžnou práci je VSCode naprosto adekvátní (s nainstalovanými rozšířeními pro PHP).

### Struktura skriptu `.php`

PHP skript je HTML s PHP kódem vloženým mezi značky `<?php` a `?>`. Závěrečná značka není povinná.

Pokud je v konfiguraci PHP zapnuto `short_open_tag`, lze pro vkládání PHP kódu použít `<?` a `?>`

Každý příkaz v PHP končí středníkem, s výjimkou posledního příkazu před `?>` – zde je středník nepovinný.

```html
<!DOCTYPE html>
<!-- basic HTML5 template -->
<html lang="cs"><!-- NOT 'cz'! -->

<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>HTML 5 Boilerplate</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>
    HTML5
</body>

</html>
```

```html
<b>plain HTML</b>
```

```
HTML :
<?php echo 'PHP1'; ?> :
<?php echo 'PHP2';
echo 'PHP3' ?>
```

```
HTML :
<? echo 'PHP1'; ?>
```

```
<?php phpinfo();
```




### echo, print, print_r, var_dump

[echo](https://www.php.net/manual/en/function.echo.php) vypíše hodnoty argumentů (vloží je do HTML). Jako zkratku lze místo `echo` použít dvojici značek `<?=` a `?>`.

[print](https://www.php.net/manual/en/function.print.php) je podobné, ale akceptuje jen jeden argument.

Pro výpis složitějších typů, včetně jejich struktury, použijte [print_r](https://www.php.net/manual/en/function.print-r.php).

Diagnostické výpisy jsou možné pomocí [var_dump](https://www.php.net/manual/en/function.var-dump.php).

```
<? echo 'one', 'two', 'three', '\n'; ?>

<?= 'shortcut', 'one', 'two', 'three', "\n"; ?>

<? print 'print'; ?>

<? print_r(['print']); ?>
```

### generování HTML

Jsou v zásadě dvě možnosti:
* přepínat mezi HTML a PHP
* vše generovat z PHP pomocí `echo`.

```
<h4>Echo:</h4>
<? $jaky = 'tučný' ?>
<?
echo 'Toto je <b>', $jaky, '</b> text.';
?>

<h4>HTML/PHP:</h4>
Toto je <b>
    <?= $jaky ?>
</b> text.
```

### komentáře

* jednořádkové
* víceřádkové.

```
<?
echo 'Hi'; // one-line comment
echo 'Hi'; # one-line comment
echo 'Hi'; /* C-style comment
   */
```


### datové typy

* řetězce
    * bez expanze proměnných (`'...'`)
    * s expanzí proměnných (`"..."`) – escape sekvence jako v C
    * heredoc

* čísla
    * celá (desítková, osmičková, šestnáctková)
    * reálná (s exponentem)

* pole, třídy, objekty

(9)

### operátory

spojování řetězců . .=

z koerzí == !=
bez koerze === !==

koerze na číslo

dualita and or && || (short circuit)

matematické
inc dec
přiřazení s operací

### proměnné

Začínají `$`. Vznikají přiřazením, mají dynamické typy, lze je recyklovat (použít opakovaně pro různý účel).

Proměnnou lze zrušit pomocí [unset](https://www.php.net/manual/en/function.unset.php).

Použití neexistující proměnné může generovat varovnou zprávu, v závislosti na nastavení [error_reporting](https://www.php.net/manual/en/function.error-reporting.php). Varovné zprávy lze potlačit znakem `@`.

### podmínky

if (...) ...;
if (...) ...; else ...;

### while
### do while
### for
### foreach

break continue

### switch
default

### die

### pole

od v. 7 []

### funkce

return

lambda

### globální a lokální proměnné

## formuláře

form action method

input

get a put

## regul8rn9 v7razy

## vkládání souborů include require include_once 