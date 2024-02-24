# Cvičení 1 – Značkovací jazyk XML

V tomto cvičení si vyzkoušíte vytvořit XML datový soubor, který budete validovat pomocí jazyka [PHP](https://cs.wikipedia.org/wiki/PHP) na [Apache](https://cs.wikipedia.org/wiki/Apache_HTTP_Server) webovém serveru.

Validaci správné struktury datového souboru budete také provádět pomocí přiloženého [DTD](https://en.wikipedia.org/wiki/Document_type_definition) souboru.

Server Apache spustíte ve virtuákním počítači vytvočeném pomocí softwaru [Docker](https://en.wikipedia.org/wiki/Docker_(software)) pro který máte připraven skript <tt>Dockerfile</tt> a [YAML](https://en.wikipedia.org/wiki/YAML) soubor <tt>compose.yaml</tt>.

### Obsah:
* Vytvoření propojených docker obrazů a spuštění LAMP kontejneru pomocí *Docker Compose*
* Jazyk XML
* Well-formed XML
* XML strom
* Validace XML, s pomocí DTD

## Docker kontejner: [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle))  (Linux – Apache – MySQL – PHP)

[Docker](https://www.docker.com/) je softwarový nástroj („virtualizační platforma“), která umožňuje vytvářet tzv. docker obrazy (*images*) a spouštět je v docker kontejnerech (*containers*). Obraz si lze představit jako read-only momentku (*snapshot*) virtualizovaného počítače s operačním systémem, na kterém jsou nainstalovány potřebné programy.

Obraz je typicky založen na minimální spustitelné verzi operačního systému. To je tzv. základ (*base*) docker obrazu. Potřebný obraz je pak sestaven tak, že do základu se pomocí skriptu, uloženým v textovém souboru *Dockerfile*, doinstalují další potřebné utility a programy.

Z docker obrazů lze pak spouštět nezávislé docker kontejnery, to jest běžící virtualizované počítače, které transparentně využívají služby hostitelského (*host*) operačního systému.

*Docker Compose* propojí několik kontejnerů do jedné běžící aplikace.

### Projekt 1: pracovní složky/adresáře (*folders*/*directories*) a soubory (*files*)

Na disku si připravte následující stromovou strukturu složek a souborů:

1. Založte si novou složku, která bude sloužit jako váš pracovní adresář, např. `Projekt 1`.
2. V pracovním adresáři vytvořte soubor `compose.yaml`.
3. V pracovním adresáři vytvořte podadresář (*subfolder*, *subdirectory*) `php`, pro PHP programy.
4. V adresáři `php` vytvořte soubor s názvem `Dockerfile`.
5. V adresáři `php` vytvořte podadresář `src` (obvyklá zkratka pro *source* – zdrojový kód).
6. V adresáři `src` vytvořte soubor s názvem `index.php`. V něm bude obsah webové stránky.

Takto bude na vypadat počáteční struktura:
```
Projekt 1
├── compose.yaml
└── php
    ├── Dockerfile
    └── src
        ├── index.php
```
Do odpovídajících souborů vložte následující obsah (nebo si do adresářů nahrajte přiložené soubory):

#### `Dockerfile`
```Dockerfile
# základní Docker obraz s PHP a Apache
FROM php:8-apache

# aktualizace systému
RUN apt update && apt upgrade -y

# instalace rozšíření pro XSL procesor
RUN apt install -y libxslt1-dev
RUN docker-php-ext-install xsl

# instalace rozšíření mysqli pro komunikaci s mysql databází
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# úklid dále nepotřebných souborů
RUN apt remove -y libxslt1-dev icu-devtools libicu-dev libxml2-dev
RUN rm -rf /var/lib/apt/lists/*
```
*Dockerfile* je soubor, který slouží Dockeru pro vytvoření obrazu. Uvedený Dockerfile provede následující:
* Stáhne základní obraz Linuxové distribuce s nainstalovaným jazykem PHP a Apache serverem.
* Nainstaluje aktualizace systému, které proběhly po vytvoření základního obrazu.
* Nainstaluje rozšíření PHP s XSL procesorem (který není součástí standardní distribuce PHP).
* Nainstaluje PHP rozšíření (driver) [myslqi](https://www.php.net/manual/en/book.mysqli.php) pro připojení PHP k MySQL databázi.

Základní obraz [php:8-apache](https://hub.docker.com/_/php) je minimální Linuxová distribuce Debian, s nainstalovaným interpretrem PHP a webovým serverem Apache ([httpd](https://en.wikipedia.org/wiki/Httpd)).

#### `compose.yaml`
```YAML
services:
  # PHP a Apache, popsáno v Dockerfile
  php-apache:
    container_name: php-apache
    build:
      context: ./php              # zde se nalézá Dockerfile
      dockerfile: Dockerfile
    depends_on:
      - db
    volumes:
      - ./php/src:/var/www/html/  # mapování vnější/vnitřní složky
    ports:
      - 8000:80                   # mapování vnějšího/vnitřního portu Apache

  # instalace databáze MySQL
  db:
    container_name: db
    image: mysql                  # základní obraz
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: db
      MYSQL_USER: admin
      MYSQL_PASSWORD: heslo
    ports:
      - 9906:3306                 # mapování vnějšího/vnitřního portu MySQL

  # instalace phpmyadmin pro správu databází
  phpmyadmin:
    image: phpmyadmin/phpmyadmin  # základní obraz
    ports:
      - 8080:80                   # port 80 bude zveřejněn jako 8080
    restart: always
    environment:
      PMA_HOST: db
    depends_on:
      - db
```

Nástroj *Docker Compose* propojí několik Docker obrazů do jednoho spolupracujícího celku a spustí tzv. multikontejnerovou aplikaci.

Konfigurace naší aplikace je popsána v souboru <tt>compose.yaml</tt>, podle kterého Docker Compose:
1. Sestaví obraz z <tt>Dockerfile</tt>, propojí ho s databázovým obrazem, a nastaví vnější port webového serveru na 8000. Dále mapuje vnitřní adresář Apache serveru <tt>/var/www/html</tt>, ve kterém jsou data pro webovou stránku, na náš vnější adresář <tt>./php/src</tt>.
2. Stáhne databázový obraz [mysql](https://hub.docker.com/_/mysql) z *Docker Hub* repositáře, namapuje port databáze na vnější port 9906, nastaví root heslo, vytvoří uživatele <tt>admin</tt> a nastaví mu heslo.
3. Stáhne docker obraz [phpmyadmin](https://hub.docker.com/_/phpmyadmin) z *Docker Hub*, nastaví jeho vnější port na 8080 a propojí ho s databázovým obrazem.

#### `index.php`
```php
<!DOCTYPE html>
<html lang="cs">

<?php $title = 'XML validátor' ?>

<head>
    <title>
        <?= $title ?>
    </title>
</head>

<body>
    <h1>
        <?= $title ?>
    </h1>

    <p>Nahrajte XML soubor, případně také DTD soubor.</p>
    <hr>
    <form enctype="multipart/form-data" method="POST">
        <table>
            <tr>
                <td>XML soubor:</td>
                <td><input type="file" name="xml" accept="text/xml" data-max-file-size="2M"></td>
            </tr>
            <tr>
                <td>DTD soubor:</td>
                <td><input type="file" name="dtd" data-max-file-size="2M"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" type="Odeslat"></td>
            </tr>
        </table>
    </form>
    <hr>

    <?php
    function printErrors()
    { ?>
        <table>
            <?php foreach (libxml_get_errors() as $error) { ?>
                <tr>
                    <td>
                        <?= $error->line ?>
                    </td>
                    <td>
                        <?= $error->message ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?php
    }

    function validate($xmlPath, $dtdPath = '')
    {
        $doc = new DOMDocument;

        // proběhne kontrola well-formed
        libxml_use_internal_errors(true);
        $doc->loadXML(file_get_contents($xmlPath));
        printErrors();
        libxml_use_internal_errors(false);

        // Máme root a DTD?
        @$root = $doc->firstElementChild->tagName;
        if ($root && $dtdPath) {
            $root = $doc->firstElementChild->tagName;
            $systemId = 'data://text/plain;base64,' . base64_encode(file_get_contents($dtdPath));

            echo "<p>Validuji podle DTD. Kořen: <b>$root</b></p>";

            // inject DTD into XML
            $creator = new DOMImplementation;
            $doctype = $creator->createDocumentType($root, '', $systemId);
            $newDoc = $creator->createDocument(null, '', $doctype);
            $newDoc->encoding = "utf-8";

            $oldRootNode = $doc->getElementsByTagName($root)->item(0);
            $newRootNode = $newDoc->importNode($oldRootNode, true);

            $newDoc->appendChild($newRootNode);
            $doc = $newDoc;
        }

        // validace
        libxml_use_internal_errors(true);
        $isValid = $doc->validate();
        printErrors();
        libxml_use_internal_errors(false);

        return $isValid;
    }

    // poslané soubory
    $xmlFile = @$_FILES['xml'];
    $dtdFile = @$_FILES['dtd'];

    // Máme XML?
    if (@$xmlTmpName = $xmlFile['tmp_name']) {
        $dtdTmpName = $dtdFile['tmp_name'];
        $isValid = validate($xmlTmpName, $dtdTmpName);
        if ($isValid)
            echo "Nahraný XML soubor je validní.";
    }
    ?>
</body>

</html>
```

Tento soubor obsahuje PHP skript, který validuje XML soubor, volitelně také vůči souboru DTD. PHP umí validovat pomocí DTD dat pouze pokud jsou součástí XML souboru. Proto tento skript vytvoří nový XML soubor, do kterého vloží DTD data.

Tento postup je poněkud neobratný. V praxi budete používat XSD soubory, které se naučíte používat v příštím cvičení. DTD soubory používají zastaralý formát se specifickým jazykem a omezenými možnostmi, který se ale dobře čte a je snadno zapamatovatelný pro jednoduchou validaci. Proto doporučuji se jejich strukturu naučit.

### Docker v příkazové řádce

Celou sestavu spustíme pomocí [příkazu v terminálu](https://docs.docker.com/engine/reference/commandline/compose_up/):
```bash
docker compose up
```
Docker Compose sestaví obrazy a spustí podle nich kombinaci kontejnerů. Pokud vše proběhne správně, bude naše webová aplikace přístupná v prohlížeči na URL [http://localhost:8000](http://localhost:8000).


Další užitečné, často používané příkazy pro Docker jsou:

|                                     |                                       |
|--------------                       |-----------                            |
| Připojení terminálu k běžícímu kontejneru | <tt>docker compose exec &lt;id> bash<tt>|
| Vypsání všech běžících kontejnerů:  | <tt>docker ps</tt>                    |
| Zastavení všech kontejnerů:         | <tt>docker stop $(docker ps -q)</tt>  |
| Smazání všech kontejnerů:           | <tt>docker rm $(docker ps -aq)</tt>   |
| Vypsání všech obrazů:               | <tt>docker images</tt>                |
| Smazání všech obrazů:               | <tt>docker rmi $(docker images -q)</tt> |

## Jazyk XML

Pravděpodobně jste se již někdy setkali s XML kódem a pokud ne, tak jste si ještě pravděpodobněji setkali s HTML kódem, který představuje podmnožinu XML. Jazyk XML představuje standard pro počítačová data, které je možné vyměňovat mezi různými platformami. Mohu například stáhnout data z databáze a zobrazit je na mobilní aplikaci, webové stránce, textovém dokumentu nebo si je ponechat v raw podobě.

Prohlédněte si ukázku XML kódu pro popis dat na následujícím odkazu: [W3Schools XML Introduction](https://w3schools.com/xml/xml_whatis.asp).

Každý XML kód se skládá z elementů, které se skládají ze značky (tag) a textu: [W3Schools XML Elements](https://w3schools.com/xml/xml_elements.asp).

Element může také mít atributy, které obsahují dodatečnou informaci: [W3Schools XML Attributes](https://w3schools.com/xml/xml_attributes.asp).

Místo atributů je možné využít další, vnořené elementy (děti – *children*) a neexistuje žádný standard pro to, jaká informace by měla být dodána jako element a jaká jako atribut. Já osobně doporučuji, aby elementy byly informace pro čtenáře a atributy informace pro aplikaci, kterou XML soubor zpracováváte. To ovšem může způsobat problém s tzv. validací. Více o problematice elementy vs. atributy naleznete na [W3Schools Elements vs. Attr](http://w3schools.com/xml/xml_dtd_el_vs_attr.asp).

Jelikož mohou mít XML elementy stejné názvy, ale zcela jiný význam, mohly by se elementy při zpracování aplikací plést. Z toho důvodu je možné k elementům přidat prefix, který elementy dále kategorizuje do jmenných prostorů (*namespaces*). Příklad může být problém table jako stolu a table jako tabulky: [W3Schools XML Namespaces](https://w3schools.com/xml/xml_namespaces.asp).

### ❖ Úkol 1.1: Student

Vytvořte jednoduchý XML dokument `student.xml`, ve kterém budou informace o entitě „student naší univerzity“. Měl by tedy obsahovat informace jako jméno, příjmení, studentské číslo, fakulta, aj. Některé informace můžete uložit do vnořených elementů, jiné do atributů.

## Well-Formed XML

XML představuje velice jednoduchý formát kódu, jelikož je struktura téměr celá na vás. Existuje pouze pár pravidel [XML syntaxe](https://w3schools.com/xml/xml_syntax.asp). Pokud je dodržíte, pak je váš XML dokument považován za tzv. dobře strukturovaný (*well-formed*):
1. XML dokument musí obsahovat kořenový element (ten nemá sourozence (*siblings*), jen děti (*children*)).
2. Pokud je v XML dokumentu prolog (používáme pro specifikaci kódování, defaultně UTF-8), pak musí být prvním řádkem souboru.
3. Všechny elementy musí být uzavřené (výjimku tvoří prolog).
4. Značky jsou case sensitive.
5. Elementy musí být řádně zanořené, nesmí se křížit.
6. Hodnoty atributů musí být v uvozovkách, dvojitých nebo jednoduchých.
7. Některé znaky (`<`, `&`) mají speciální význam a proto musí být vloženy jako entity (`&lt;`, `&amp;`).
8. Komentáře (`<!--` ... `-->`) nesmí obsahovat dvě pomlčky jinde, než na konci komentáře.
9. Bílé znaky nejsou ořezávány.
10. Přechod na nový řádek je pomocí znaku LF (*line feed*) – na to je nutné dát pozor při práci ve Windows.

Zda je XML *well-formed* lze otestovat pomocí XML validátorů, např.: [W3Schools XML Validator](https://w3schools.com/xml/xml_validator.asp), nebo naším PHP validátorem.

### ❖ Úkol 1.2: Well-formed XML

Prohlédněte si následující XML kód a opravte ho tak, aby byl well-formed. Výsledek otestujte validátorem.

#### `knihy.xml`
```
<kniha>
    <!-- každá kniha obsahuje dva názvy a to český a anglický -- specifikováno atributem -->
    <název jazyk=cz>Epos o Berygamešovi
    <název jazyk=en>Epic of Berygamesh
    <Autor>Jiří Fišer</autor>
    <postavy><postava>Berygameš</postava><postava>Škvorkidu<postavy/></postava>
</kniha>
<kniha>
    <název jazyk=cz>Pán prstenů: návrat Fišera
    <název jazyk=en>Lord of the rings: return of Fišer
    <Autor>Beránek Pavel</autor>
    <popis>
        Kniha o partě ajťáků, kteří se chystají na výpravu na zápočet na Fakultu Osudu.
    </popis>
</kniha>
<?xml version="1.0" encoding="UTF-8"?>
```

## Návrh XML stromu

XML nemá žádný standardní model pro grafickou reprezentaci, jako mají například třídy v OOP ve formě diagramů v jazyce UML. Přesto by se nám nějaký alespoň primitivní grafický model pro přemýšlení nad návrhem, komunikaci o datovém modelu v týmu nebo dokumentaci hodil. Jelikož XML představuje datovou strukturu, kde nalezneme prvotní značku (kořen), značky, obsahující další značky (větve) a značky, neobsahující žádné další značky (listy), nabízí se tak možnost zakreslit XML jako stromovou strukturu.

Na stránce [W3 Schools XML Tree](https://w3schools.com/xml/xml_tree.asp) vidíte grafickou reprezentaci XML kódu pomocí stromové struktury. Pod obrázkem naleznete kód k příslušnému stromu.

### ❖ Úkol 1.3: Struktura XML dokumentu

Vaším úkolem je vytvořit návrh struktury XML dokumentu podle následující klientské specifikace:
> Chtěl bych vytvořit webovou aplikaci pro záznam studentů naší univerzity. O studentovi zaznamenávejte informace: jméno, příjmení, studentské číslo, email, studijní rok, rozvrh, předměty, splněné předměty a další zajímavé informace.

> Chtěl bych také zaznamenat fakulty univerzity. O každé fakultě zaznamenávejte informace jako: děkan, katedry, vedoucí kateder, zaměstnanci, kontakt na zaměstnance, pozice zaměstnanců, tituly a další zajímavé informace.

## Validní XML

V úkolu 1.2 jste upravili XML soubor tak, aby byl well-formed. Kromě toho by měl být XML soubor ještě validní. Aby byl XML dokument validní, pak se musí jeho struktura řídit šablonou ve formátu DTD (*Document Type Definition*) nebo XML Schema (novější typ šablony, která je sama o sobě XML). Představit si to lze obdobně jako v objektově orientovaném programování, kde v našem případě šablona odpovídá třídě a XML dokument odpovídá objektu (instanci třídy).

Ukázku DTD naleznete na stránce: [W3Schools XML DTD](https://w3schools.com/xml/xml_dtd.asp).

Každý DTD dokument se skládá ze stavebních bloků: [W3Schools XML DTD Building Blocks](https://w3schools.com/xml/xml_dtd_building.asp) a DTD definuje strukturu na sebe navazujících bloků – jaké každý blok obsahuje potomky a jaké má příbuzné.

1. Elementy [W3Schools XML DTD Elements](https://www.w3schools.com/xml/xml_dtd_elements.asp): mohou být prázdné, s daty, s potomky, libovolnými bloky (element, data) a o různém počtu bloků (právě 1, alespoň 1, nula a více, nula nebo jeden) nebo s výčtem konkrétních bloků pomojí spojky `|`.
2. Atributy [W3Schools XML DTD Attributes](https://www.w3schools.com/xml/xml_dtd_attributes.asp): atributy mají typy (data, výčet, ID, odkaz na ID, entita, atd.) a hodnoty (pevně dané, povinné a volitelné).
3. Entity [W3Schools XML DTD Entities](https://www.w3schools.com/xml/xml_dtd_entities.asp) - zkratky za konstantní hodnoty, které často využíváte.
4. Parsovaná data - data mezi elementy, která budou zpracována parserem a entity budou rozvinuty
5. Znaková data - data mezi elementy, která se berou doslovně a nejsou nijak zpracována (entity nebudou rozvinuty a v obsahu zůstane jejich alias).

### ❖ Úkol 1.4: Validace XML pomocí DTD

Vaším dalším úkolem je napsat XML soubor s názvem `prf.xml`, která bude obsahovat informace o Přírodovědecké fakultě UJEP, nebo soubor s názvem `pf.xml`, která bude obsahovat informace o Pedagogické fakultě UJEP. Tyto soubory musí být dobře formované (well-formed), tzn. nesmí mít žádné chyby v zápisu XML elementů jako například křízení značek a podobně. Dále musí být soubor validní, což znamená, že splňuje požadavky schématu (tím je soubor `fakulta.dtd`). Ověřte, zda jsou soubory well-formed a validní pomocí validátorů.

#### `fakulta.dtd`
```
<!ELEMENT fakulta (katedra+)>
<!ATTLIST fakulta
děkan CDATA #REQUIRED>

<!ELEMENT katedra (vedoucí, zaměstnanci, předměty)>
<!ATTLIST katedra
zkratka_katedry CDATA #REQUIRED
webové_stránky CDATA "https://www.ujep.cz/cs/"
>

<!ELEMENT vedoucí (jméno, (telefon|email)+)>

<!ELEMENT jméno (#PCDATA)>

<!ELEMENT telefon (#PCDATA)>

<!ELEMENT email (#PCDATA)>

<!ELEMENT zaměstnanci (zaměstnanec+)>

<!ELEMENT zaměstnanec (jméno, (telefon|email)+, pozice?)>

<!ELEMENT pozice (lektor|asistent|odborný_asistent|docent|profesor)?>
<!ELEMENT lektor EMPTY>
<!ELEMENT asistent EMPTY>
<!ELEMENT odborný_asistent EMPTY>
<!ELEMENT docent EMPTY>
<!ELEMENT profesor EMPTY>

<!ELEMENT předměty (předmět*)>

<!ELEMENT předmět (název, popis?)>
<!ATTLIST předmět
zkratka CDATA #REQUIRED
typ (přednáška|seminář|cvičení|kombinované) "kombinované"
>

<!ELEMENT název (#PCDATA)>
<!ELEMENT popis (#PCDATA)>
```

## Domácí cvičení
### Video týdne 1: Základy internetových technologií

Jelikož jste zapsaní v kurzu Programování pro Internet, tak je dobré znát, jak fungují některé internetové (komunikace) a webové (obsah) technologie. Následující video představuje souhrn všech důležitých termínů se kterými budete pracovat: [Web Development Things you Should Know](https://youtu.be/erEgovG9WBs).
