# Cvičení 6 – XPath (řešení příkladů), základy PHP

### Obsah tohoto cvičení:

* Ukázková řešení příkladů XPath z minulého cvičení.
* Základy PHP (přehled, letem-světem).
* HTML formuláře, HTTP post, get.
* Parametry v XSL.

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

PHP skript je v zásadě HTML s PHP kódem vloženým mezi značky `<?php` a `?>`. Závěrečná značka není povinná.

Pokud je v konfiguraci PHP zapnuto `short_open_tag`, lze pro vkládání PHP kódu použít `<?` a `?>`

Každý příkaz v PHP končí středníkem, s výjimkou posledního příkazu před `?>` – zde je středník nepovinný.

Příklady (Projekt 7): 
* Jednoduchá šablona HTML5: `html5-template.php` 
* Neúplné HTML5: `html5-incomplete.php`
* PHP Info: `phpinfo.php`

⮕ [PHP Tags](https://www.php.net/manual/en/language.basic-syntax.phptags.php)
⮕ [Instruction separation](https://www.php.net/manual/en/language.basic-syntax.instruction-separation.php)

### echo, print, print_r, var_dump

[echo](https://www.php.net/manual/en/function.echo.php) vypíše hodnoty argumentů (vloží je do HTML). Jako zkratku lze místo `echo` použít dvojici značek `<?=` a `?>`.

[print](https://www.php.net/manual/en/function.print.php) je podobné, ale akceptuje jen jeden argument.

Pro výpis složitějších typů, včetně jejich struktury, použijte [print_r](https://www.php.net/manual/en/function.print-r.php).

Diagnostické výpisy jsou možné pomocí [var_dump](https://www.php.net/manual/en/function.var-dump.php).


```php
<? echo 'one', 'two', 'three'; ?>
```

```php
<?= 'shortcut', 'one', 'two', 'three'; ?>
```

```php
<? print 'print'; ?>
```

```php
<? print_r(['print']); ?>
```

```php
<? var_dump('var'); ?>
```

### Generování HTML

Jsou v zásadě dvě možnosti:
* vše generovat z PHP pomocí `echo`
* přepínat mezi HTML a PHP

```php
<h4>Vše jako echo:</h4>
<? $jaky = 'tučný' ?>
<?
echo 'Toto je <b>', $jaky, '</b> text.';
?>
```

```php
<h4>Přepínat HTML/PHP:</h4>
Toto je <b>
    <?= $jaky ?>
</b> text.
```

⮕ [Escaping from HTML](https://www.php.net/manual/en/language.basic-syntax.phpmode.php)

### Komentáře

Mohou být jednořádkové i víceřádkové.

```
<?
echo 'Hi'; // one-line comment
echo 'Hi'; # one-line comment
echo 'Hi'; /* C-style comment
   */
```

⮕ [Comments](https://www.php.net/manual/en/language.basic-syntax.comments.php)

### Datové typy

Typy jsou dynamické (určené za běhu programu). PHP se pokouší typy konvertovat, pokud je potřeba, podle kontextu (např. při porovnání čísla a řetězce).

⮕ [Types - Introduction](https://www.php.net/manual/en/language.types.intro.php)
⮕ [Type System](https://www.php.net/manual/en/language.types.type-system.php)
⮕ [Type Juggling](https://www.php.net/manual/en/language.types.type-juggling.php)

Čísla je možné zadávat v různých formátech.

⮕ [Integers](https://www.php.net/manual/en/language.types.integer.php)
⮕ [Floating-point numbers](https://www.php.net/manual/en/language.types.float.php)

Řetězce mohou být bez expanze proměnných nebo s expanzí proměnných a escape sekvencí. Řetězce také mohou reprezentovat čísla.

⮕ [Strings](https://www.php.net/manual/en/language.types.string.php)
⮕ [Numeric strings](https://www.php.net/manual/en/language.types.numeric-strings.php)

Pole v PHP jsou uspořádané, asociativní mapy. Od PHP verze 7 existuje syntax `[`..`]`.

⮕ [Arrays](https://www.php.net/manual/en/language.types.array.php)

### Operátory

⮕ [Operators](https://www.php.net/manual/en/language.operators.php)

Za zmínku stojí:
* rozdíl mezi `==` a `===`, a mezi `!=` a `!==` ⮕ [Comparison Operators](https://www.php.net/manual/en/language.operators.comparison.php) 
* dualita `and`/ `&&` a `or` / `||` ⮕ [Logical Operators](https://www.php.net/manual/en/language.operators.logical.php)


### Proměnné

Začínají `$`. Vznikají přiřazením, mají dynamické typy, lze je recyklovat (použít opakovaně pro různý účel). Proměnnou lze zrušit pomocí [unset](https://www.php.net/manual/en/function.unset.php).
⮕ [Variables - Basics](https://www.php.net/manual/en/language.variables.basics.php)

Použití neexistující proměnné může generovat varovnou zprávu, v závislosti na nastavení [error_reporting](https://www.php.net/manual/en/function.error-reporting.php). Varovné zprávy lze potlačit znakem `@`.
⮕ [Error Control Operators](https://www.php.net/manual/en/language.operators.errorcontrol.php)

### Řídicí struktury

Jsou běžného typu: [if](https://www.php.net/manual/en/control-structures.if.php), [if-else](https://www.php.net/manual/en/control-structures.else.php), [elseif](https://www.php.net/manual/en/control-structures.elseif.php), [while](https://www.php.net/manual/en/control-structures.while.php), [do while](https://www.php.net/manual/en/control-structures.do.while.php), [for](https://www.php.net/manual/en/control-structures.for.php), [foreach](https://www.php.net/manual/en/control-structures.foreach.php), [switch](https://www.php.net/manual/en/control-structures.switch.php), atd.

### die

⮕ [die](https://www.php.net/manual/en/function.die.php) (exit) ukončí skript.

### Funkce

Vedle [standardních funkcí](https://www.php.net/manual/en/functions.user-defined.php) jsou k dispozici také [anonymní (lambda/closure) funkce](https://www.php.net/manual/en/functions.anonymous.php) a to od verze 7.4 s úspornou [šipkovou notací](https://www.php.net/manual/en/functions.arrow.php).

### Vkládání souborů
* [include](https://www.php.net/manual/en/function.include.php)
* [require](https://www.php.net/manual/en/function.require.php)
* [include_once](https://www.php.net/manual/en/function.include-once.php)
* [require_once](https://www.php.net/manual/en/function.require-once.php)


## HTML formuláře

HTML [<form>](https://www.w3schools.com/html/html_forms.asp) element jsme použili již v prvním projektu. Slouží k zadávání uživatelských dat, která jsou typicky (ale ne nezbytně) odeslána na server.

Element `<form>` má různé [atributy](https://www.w3schools.com/html/html_forms_attributes.asp), z nich jsou nejpodstatnější:
* `action`: který skript na serveru obdrží data k zpracování a generuje novou stránku. Default: stejný skript, který generoval současnou stránku.
* `method`: použije-li se HTTP GET (default) nebo POST.

`<form>`...`</form>` může obsahovat vícero elementů [různých typů](https://www.w3schools.com/html/html_form_elements.asp), především elementů [<input>](https://www.w3schools.com/html/html_form_input_types.asp).

### PHP super-globální proměnné 

PHP má vestavěné tzv. [superglobals](https://www.php.net/manual/en/language.variables.superglobals.php).

* [$_GET](https://www.php.net/manual/en/reserved.variables.get.php): asociativní pole s proměnnými, které byly poslány jako HTTP GET (tedy v URL).
* [$_POST](https://www.php.net/manual/en/reserved.variables.post.php): asociativní pole s proměnnými, které byly poslány jako HTTP POST (tedy v těle HTTP požadavku).
* [$_COOKIE](https://www.php.net/manual/en/reserved.variables.cookies.php): asociativní pole s proměnnými, které byly poslány jako cookies.
* [$_REQUEST](https://www.php.net/manual/en/reserved.variables.request.php) obsahuje totéž, co `$_GET`, `$_POST` a `$_COOKIE`.
* [$_SERVER](https://www.php.net/manual/en/reserved.variables.server.php) obsahuje informace o serveru a příchozím požadavku.

### ❖ Úkol 7.2 – prozkoumejte možnosti HTML formulářů

V *Projektu 7* je skript `form.php`. Použijte jej jako základ pro experiment s `<form>`:
* method: `get` / `post`
* action: přechod na jinou stránku
* `<input>`: použijte různé typy

Formulář případně ostylujte.

### ❖ Úkol 7.3 – tabulka předmětů

Skript `form-predmety.php` obsahuje ukázkové řešení XPath problému č. 4 – tabulku s údaji pro daný předmět. Transformačnímu souboru `studium-predmet.xsl` je kód předmětu předán z PHP jako parametr.
1. Doplňte formulář (method, `<input>`, ...) a použijte PHP superglobální proměnné tak, aby uživatel mohl zadat kód požadovaného předmětu.
1. Použijte `<select>` a `<option>` tak, aby uživatel měl kódy předmětů na výběr.
1. Zkuste napsat další transformační XSL soubor, který bude pro formulář generovat seznam předmětů na výběr.
