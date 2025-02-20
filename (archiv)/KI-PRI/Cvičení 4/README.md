# Cvičení 4 – XML model a databáze

Dnes vytvoříte databázový model (databázi a tabulky) pro vaše data o fakultách a studentech.

### Předchozí cvičení:

V předchozím cvičení jste pro vaše soubory `student.xml` a `fakulta.xml` vytvořili XML styly v jazyce XSLT: `student.xsl` a `fakulta.xsl`.

### Obsah tohoto cvičení:

- Nová kostra projektu.
- Interakce s běžícími Docker kontejnery.
- Vytvoření databázových tabulek pro ukládání dat na serveru.
- Připojení PHP k databázi (mysqli).

## Nová kostra projektu

Ve složce _Projekt 4_ naleznete upravenou kostru projektu.
Hlavní změny jsou:

- Dockerfile (pro php-apache kontejner) je přesunut do `Dockerfiles/`.
- Složka `php/src/` je přejmenována na `html/`, aby lépe odpovídala příslušné složce uvnitř kontejneru (Linux serveru).
- PHP kód je rozdělen do několika PHP souborů (webových stránek).

Adresář `html/xml` obsahuje pouze _základní verzi_ souborů `fakulta.*`, jako příklad. Ve vašem vlastním projektu samozřejmě máte dokonalejší verze souborů `fakulta.*` a `student.*`.

## Interakce s běžícím kontejnerem (Linuxem)

Jeden z důvodů proč používáme Docker kontejnery je, že toto prostředí simuluje skutečnou situaci, kdy webový server běží na nějaké Linuxovské distribuci.

Běžící kontejnery vypíšete příkazem

```bash
docker ps
```

nebo je lze vidět v Docker Desktop.

Každý kontejner má unikátní CONTAINER ID. Terminál s přístupem do běžícího kontejneru otevřete příkazem

```
docker exec -ti <id> bash
```

Dále můžete používat obvyklé shellové příkazy `pwd`, `cd`, `ls`, `ls -l`, atd.

Pro větší pohodlí si můžete do kontejneru _php-apache_ doinstalovat další nástroje, jako např. Midnight Commander nebo váš oblíbený editor

```bash
apt update
apt install mc nano vim
```

### ❖ Úkol 4.1: konfigurační soubory Apache a PHP

Zběžně si prohlédněte konfigurační soubory, které naleznete v kontejneru _php-apache_ v adresářích `/etc/apache2` a v `/usr/local/etc/php`.

V konfiguraci Apache vyhledejte např. _DocumentRoot_.

Konfiguraci PHP vypíšete:

```
php -v
php -i
```

A běžící procesy zobrazíte příkazem

```
top
```

Všechny tyto údaje jsou základní nástroje k řešení problémových situací, když na webovém serveru něco nefunguje.

## Vytvoření databázových tabulek

Vaším hlavním dnešním úkolem je si vytvořit databázové tabulky pro ukládání dat o fakultách a studentech.

V našem projektu jsou již připraveny dva nástroje na administraci databáze: _phpadmin_ a _adminer_. Běží v prohlížeči na URL `localhost:8080` a `localhost:8088`. Přihlašovací údaje jsou _admin/heslo_ (nastaveny v `compose.yaml`). Databáze _univerzita_ již je také vytvořena.

### ❖ Úkol 4.2: tabulky `student` a `fakulta`, případně další (katedra, předmět apod.)

Pomocí _phpadmin_ nebo _adminer_ založte v databázi tabulky pro vaše data. Struktura tabulek by měla odpovídat vašemu datovému modelu, který jste vytvořili v XML. V tomto kursu se nezabýváme návrhem databází, není tedy nutné, aby vaše tabulky byly dokonalé. Měly by ale obsahovat pole odpovídající elementům a atributům, které máte v XML, a pole by měla mít odpovídající [datový typ](https://dev.mysql.com/doc/refman/8.3/en/data-types.html).

Pokud víte jak, přidejte další náležitosti, např. indexy apod.

### ❖ Úkol 4.3: vložení dat

Pomocí _phpadmin_ nebo _adminer_ naplňte vytvořené tabulky testovacími daty o studentech a fakultách.

### ❖ Úkol 4.4: export dat

Strukturu tabulek a vložená data vyexportujte jako SQL soubor. Ten si uložte, budete ho potřebovat pro obnovení dat, vždy, když smažete a znovu vytvoříte Docker kontejner.

## Připojení PHP k databázi (mysqli)

Seznamte se s PHP rozšířením MySQLi: [W3 Schools](https://www.w3schools.com/php/php_ref_mysqli.asp), [PHP Manual](https://www.php.net/manual/en/book.mysqli.php).

MySQLi má duální (procedurální a objektově orientované) rozhraní.

### ❖ Úkol 4.5: test databázového spojení

V příkazovém řádku v kontejneru php-apache si vyzkoušejte připojení databáze.

```
php -a
php > mysqli_connect("database","admin","heslo","univerzita");
php > new mysqli("database","admin","heslo","univerzita");
```

Výsledek připojení můžete vypsat pomocí [print_r()](https://www.php.net/manual/en/function.print-r.php).
