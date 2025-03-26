# Semestrální (zápočtový) projekt

Vytvořte _jednoduchou_ full-stack (odzadu dopředu) webovou aplikaci, která bude zpracovávat
(ukládat, číst, filtrovat) a zobrazovat data podle vašeho výběru.

Námět si zvolte svobodně. Mohou to být například: knihy v knihovně, filmy v kinech, studenti
ve škole, jídla v restauraci, recepty na vaření, země na světě, piva v pivovarech ... a
podobně.

Samozřejmě si můžete námět zvolit tak, aby měl souvilost s vaší prací v jiných předmětech.

Data budou uložena v databázi a/nebo na disku v XML souborech.

Webová aplikace se bude skládat z několik málo (3-4+) stránek. Alespoň jedna stránka bude
obsahovat HTML formulář pro vkládání dat, zadávání filtrů nebo požadavů, nebo podobně.

Na stránkách aplikace budou prezentována, vhodným způsobem, data z databáze a/nebo z XML
souborů.

**Cílem není**:

- rozsáhlý, složitý projekt.

**Cílem je**:

- projekt, ve kterém si _v rozumném rozsahu_ vyzkoušíte dané technologie
- projekt, který obsahuje kód, kterému dobře rozumíte (pozor na generovaný kód, tomu musíte
  porozumět a v každém případě byste jej vždy měli revidovat, zbavit nepotřebných částí, a
  vhodně upravit)
- projekt, který je dobře organizovaný, přehledný, snadno čitelný a pochopitelný a, pokud
  možno, minimalistický (nejsou v něm zbytečnosti)
- kód, který je psaný podle zásad dobrého programování (KISS, DRY, YAGNI)

## Použité technologie:

V projektu použijte následující technologie:

- Server (backend: Docker/Linux + webový server):

  - Databáze: např. PostgreSQL, MySQL, MariaDB, SQLite, nebo jiná (také NoSQL)
  - PHP
  - XML + manipulace XML DOM pomocí PHP

- Klient (frontend: prohlížeč):

  - HTML5/XML, CSS, JS
  - manipulace HTML(XML) DOM pomocí JS
  - volitelně: AJAX (fetch API)

<img src="../assets/Vanilla.png" width="100">

## Části projektu:

- XML pro přenos dat mezi klientem a serverem, pro zobrazování dat, případně uládání dat:

  - navrhněte strukturu XML souborů, XSD pro jejich validaci, XSL pro transformaci na HTML

- Server:

  - Navrhněte a vytvořte potřebné databázové tabulky, vložte/importujte do nich potřebná
    (počáteční) data.
  - Data mohou být také (navíc) uložena v XML souborech na disku a do XML souborů ukládána.
  - Vytvořte PHP skripty pro generování HTML/XML stránek, pro zpracování požadavků z klienta
    a pro čtení a zápis dat. Přidejte JS, který se bude provádět na straně klienta.
  - Stránky _jednoduše_ ostylujte pomocí CSS.

- Klient:

  - prohlížeč zobrazuje HTML a/nebo XML generované serverem a provádí JS skripty

- JavaScript (JS):

  - Obsluhuje události (uživatelské interakce, timer)
  - Manipuluje HTML DOM a případně XML DOM
  - volitelně lze zahrnout jednoduchou reaktivitu (událost → JS obsluha → manipulace DOM →
    změna zobrazení)

- Komunikace mezi klientem a serverem probíhá pomocí

  - standardně: HTTP POST/GET
  - volitelně pomocí AJAX (fetch API)

- Data jsou mezi klientem a serverem přenášena pomocí

  - standardně: HTTP POST/GET (formuláře)
  - ve formátu XML (data ze serveru, nebo nahrávání souborů z klientu)

  Přenášená XML data musí být validována.

## Odesílání XML dat server → klient

- PHP skript podle požadavků z klientu přečte data z databáze, vytvoří z nich XML soubor
  (manipulací XML DOM)
- a/nebo přečte XML soubor z disku
- XML data validuje pomocí XSD
- odešle data klientovi jako XML, nebo transformovaná na HTML pomocí XSL
- klient zobrazí XML/HTML data v prohlížeči, nebo XML data transformuje na HTML, které
  zobrazí
