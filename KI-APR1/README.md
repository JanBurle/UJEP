# Algoritmizace a programování I[^1]

[^1]: Zde uvedené materiály jsou z velké části založeny na repozitáři [Ing. P. Beránka](https://github.com/pavelberanek91/UJEP/tree/main/APR1).

## 1. Informace o předmětu

Úvodní kurz _Algoritmizace a programování I_ (první část) se zaměřuje na základy procedurálního a objektově orientovaného programování. Pozornost je soustředěna především na objektovou reprezentaci základních kolekcí (řetězců, seznamů, slovníků) a na elementární algoritmy nad nimi. Kurz je určen pro začátečníky — nepředpokládají se předchozí znalosti programování. Výuka — přednášky a cvičení — bude probíhat v jazyce Python.

Přednáší: [Mgr. Jiří Fišer, Ph.D.](https://ki.ujep.cz/cs/personalni-slozeni/jiri-fiser/)

## 2. Informace o cvičení

Cvičení jsou vedena formou samostatné práce studentů na úkolech podle zadání v tomto repozitáři. Cvičící má úlohu mentora: pomáhá s vysvětlováním problematiky, hledá chyby v případě „záseku“ studenta a radí, jak cvičení vyřešit. Odpovědnost za učení je převážně na studentovi. Teorii potřebnou na cvičení studenti získají z přednášek a dalších uvedených materiálů.

### Cvičení vedou:

1. [Ing. Mgr. Pavel Beránek, MBA, LL.M.](https://ki.ujep.cz/cs/personalni-slozeni/pavel-beranek/)
2. [Ing. Jan Burle, Ph.D.](https://ki.ujep.cz/cs/personalni-slozeni/jan-burle/)

## 3. Podmínky získání zápočtu:

Podmínkou získání zápočtu je úspěšné napsání zápočtového písemného testu nebo zpracování podstatné seminární práce (projektu). Zápočet je možné i získat, pokud na základě plnění úkolů ze cvičení cvičící usoudí, že programátorská erudice studenta splňuje požadavky předmětu.

Zápočtový test proběhne ve zkouškovém období. Test bude psán na papír tužkou nebo perem. Cílem je napsat sadu kratších programů, které řeší zadané úlohy.

Při psaní zápočtového testu mohou studenti použít libovolné tištěné materiály. Povoleny ale nejsou jakékoliv elektronické prostředky (tablet, laptop, telefon, chytré hodinky, ...).

Námět seminární práce, která nahrazuje zápočtový test, si vymýšlí student sám a schvaluje jej cvičící, nebo jej, v případě zájmu studenta, může také zadat přednášející nebo cvičící. Kontrola toho, zda student své práci dostatečně rozumí (dokáže vysvětlit jednotlivé řádky kódu a mentální postup za nimi) proběhne na konzultacích příslušného cvičícího (pokud garant předmětu neurčí jinak).

## 4. Sylabus přednášek

1. Základní terminologie objektově orientovaného programování, objekty základních tříd (čísla, logické hodnoty) a operace resp. metody nad nimi
2. Proměnné, standardní vstup a výstup, větvení programu (konstrukce `if-else`)
3. Cykly (`while` a `for`), předčasné ukončení cyklů
4. Řetězce a metody nad řetězci, indexace, modifikovatelné odkazované hodnoty (referenční sémantika)
5. Seznamy (rozhraní), asymptotická (časová) složitost
6. Uživatelské funkce (vstupní parametry, návratové hodnoty, oblast viditelnosti proměnných), n-tice
7. Klíčové algoritmy nad seznamy (duplikace, filtrace, redukce)
8. Slovníky: rozhraní, využití pro representaci asociativních polí, řídkých polí a mezipamětí (cache)
9. Hashovací tabulky (interní implementace, hashovací funkce)
10. Vstup a výstup do souborů (textový)
11. Vstup a výstup do souborů (binární), bytová pole
12. Výjimky a základní ošetření výjimek, kontextový manager (`with`) použitý ve správě prostředků
13. Závěrečné shrnutí

## 5. Cvičení

| Týden | Název                     | Zadání               | Řešení                                                                           |
| ----: | :------------------------ | :------------------- | :------------------------------------------------------------------------------- |
|    01 | Úvod, čísla               | [01](./01/README.md) |                                                                                  |
|    02 | Vstup a výstup, podmínky  | [02](./02/README.md) | [02](./02/code.md)                                                               |
|    03 | `if-else`, `for`, `while` | [03](./03/README.md) | [03](./03/code.md)                                                               |
|    04 | Cykly, indexace, řetězce  | [04](./04/README.md) | [04](./04/code.md)                                                               |
|    05 | Cykly a úlohy...          | [05](./05/README.md) | [05](./05/code.md)                                                               |
|    06 | Cykly a želva             | [06](./06/README.md) | [06](./06/code.md)                                                               |
|    07 | Kolekce: seznamy          | [07](./07/README.md) | [07](./07/code.md)                                                               |
|    08 | Operace nad seznamy       | [08](./08/README.md) | [08](./08/code.md)                                                               |
|    09 | Řešení úloh               | [09](./09/README.md) |                                                                                  |
|    10 | Řešení úloh               | [10](./10/README.md) |                                                                                  |
|    11 | Práce se soubory          | [11](./11/README.md) | [kód](https://colab.research.google.com/drive/1cKdaOy9MP73cUfmC6yFMccTQFDny2UdI) |
|    12 | Řešení zápočtových úloh   |                      |                                                                                  |
|    13 | JSON APIs                 |                      | [kód](https://colab.research.google.com/drive/1UAyAirA4YvDRCteXWeyelk4pmHTXx9IJ) |

## 6. Umět != odpovědět, umět == dělat

Požadavky tohoto kursu není možné splnit tím, že se student před zkouškou nabifluje materiál. Nestačí si zapamatovat odpovědi na otázky. Algoritmizaci a programování je nutno _trénovat_ tak, že člověk programy konstruuje, sestavuje, píše, opravuje. Programujte stále, od začátku semestru, několik hodin týdně. Nenechávejte to na zkouškové.
