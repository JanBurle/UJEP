# Relační databázové systémy

Rozšiřující kurs SQL a relačních databázových systémů (RDBS),
zaměřený na moderní rysy SQL a správu databází.

## Informace o předmětu

Kurs navazuje na _Úvod do relačních databází (URDB)_, který
rozšiřuje v několika směrech:

- pokročilé používání SQL dotazů
- optimalizace SQL dotazů s využitím znalostí vnitřní funkce
  DBS
- administrace databázových systémů
- programování na straně serveru (uložené procedury) a na
  straně klienta (Python, JavaScript)

Přednášky se budou orientovat na databázový systém PostgreSQL.

| Přednáší:                  |
| -------------------------- |
| [Ing. Jan Burle, Ph.D.][1] |

[1]: https://ki.ujep.cz/cs/personalni-slozeni/jan-burle/

## Informace o cvičení

Cvičení se zaměřují na tvorbu databázových systémů: návrh
databázového modelu, jeho realizaci a administraci. Cílem
cvičení je seminární práce/projekt: vytvoření aplikace v
databázovém systému jako je PostgreSQL, MariaDB, MySQL, Db2,
Oracle, apod.

| Cvičení vede:              |
| -------------------------- |
| [Mgr. Květuše Sýkorová][2] |

[2]:
  https://ki.ujep.cz/cs/personalni-slozeni/kvetuse-sykorova/

## Zkouška

Zkouška bude mít písemnou a ústní část. Při zkoušce bude
student odpovídat na teoretické otázky, řešit krátké úlohy a
diskutovat svůj seminární projekt.

## Přednášky

| Týden | Téma                                                          |
| ----: | ------------------------------------------------------------- |
|     1 | [Úvod, PostgreSQL](md/01a.md)                                 |
|       | [Lepší model](md/01b.md)                                      |
|     2 | [Spojování tabulek, agregace, pohledy](md/02.md)              |
|     3 | [Vnořený `select` a alternativa: analytické funkce](md/03.md) |
|     4 | [Indexy a analýza dotazů](md/04.md)                           |
|     5 | [Fulltextové vyhledávání](md/05.md)                           |
|     6 | [Rekurzivní CTE a reprezentace hierarchií](md/06.md)          |
|     7 | [Uložené funkce a procedury](md/07.md)                        |
|     8 | [Uživatelé, procedury, triggery](md/08.md)                    |
|     9 | [Kursory, výjimky](md/09.md)                                  |
|    10 | [Programování klientů: Python, PHP](md/10.md)                 |
|    11 | [ORM](md/11.md)                                               |
|    12 | [Různé]<!--(md/12.md)-->                                      |
|    13 | [Různé]<!--(md/13.md)-->                                      |

## Zdroje

|              Materiál | Odkaz                            |
| --------------------: | -------------------------------- |
|   Základní literatura | [Dokumentace PostgreSQL][11]     |
| Doporučená literatura | <!-- TODO -->                    |
|                 Opory | [Úvod do relačních databází][12] |
|                       | [Relační databázové systémy][13] |

[11]: https://www.postgresql.org/docs/current/
[12]:
  https://ki.ujep.cz/opory/Aplikovana_Informatika/Bc/Uvod_do_relacnich_databazi.pdf
[13]:
  https://ki.ujep.cz/opory/Aplikovana_Informatika/Bc/Relacni_databazove_systemy.pdf
