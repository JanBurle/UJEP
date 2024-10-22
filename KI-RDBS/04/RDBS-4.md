OPTIMALIZACE DOTAZŮ
Při optimalizaci dotazů se musí zohledňovat velikost
zpracovávaných tabulek (včetně dočasných
tabulek vzniklých během provádění komplexnějších dotazů)
 velikost tabulky je primárně dána počtem řádků (i když rozsah sloupců může také hrát roli,
je však v praxi omezený)
microtabulky
= tabulky s jedním nebo několika málo sloupci
 optimalizace je kontraproduktivní
mezotabulky
= rozsah desítek až tisíců řádku pomocné struktury se do jednoho diskového bloku
resp. stránky paměti)
 bitmap scan, hash join
macrotabulky
 index scan, merge join

2.1 Prováděcí plán
Rozsah průběžně vytvářených tabulek lze zjistit jen obtížně.
výjimka: agregační funkce, dotazy se sekcí LIMIT
pr
oto se běžně jen odhaduje:
 z velikosti fyzických tabulek
 z empiricky zjištěných rozdělení pravděpodobnosti
 z výsledků předchozích obdobných dotazů
Na základě těchto údajů se stanovuje prováděcí plán
Dobré odhady vyžadují
průběžnou analýzu data a provádění reálně využívaných dotazů (tzv.
postupná akomodace).
Jak zjistit jaký plán byl použit:
EXPLAIN [ANALYZE] dotaz
Vypisuje detailní plán s uvedením použitých mechanismů, odhadovanou cenou a počtem řádků
tabulek
ANALYZE = plán je vykonán
údaje o reálném provedení jsou doplněny do výstupu pro srovnání

ÚKOLY
Diskutujte s pomocí dokumentace
https://www.postgresql.org/docs/9.4/using explain.html
následující výpis plánu:
HashAggregate (cost=39.53..39.53 rows=1 width=8) (actual time=0.661..0.672
rows=7 loops=1)
--> Index Scan using test_pkey on test (cost=0.00..32.97 rows=1311 width=8)
(actual time=0.050..0.395 rows=99 loops=1)
Index Cond: ((id > $1) AND (id < $2))
Total runtime: 0.851 ms
(4 rows)

2.2 Indexy
Indexy jsou pomocné datové struktury na disku, které umožňují výrazně urychlit některé operace
(vyhledávání, třídění) u mezotabulek a
Sami však vyžadují jistou režii pr
o své uložení a správu (pokud nejsou nezbytné, neměly by být
vytvářeny). Indexy se musí měnit při každém vložení řádku v tabulce pro níž jsou vytvořeny.
CREATE INDEX jméno_indexu ON tabulka (výraz);
Prostudujte
https://www.postgresql.org/docs/9.1/indexes intro.html
Nejjednodušší je vytvoření indexu nad jedním sloupcem (výrazem je jméno sloupce). Indexy
optimalizují selekci (konstrukce typu WHERE sloupec = hodnota) a spojení.

2.2.1 Typy ind exů
b
tree založený na b tree. Využitelný pro všechny relační operace a po určité konfiguraci i pro
vzory se shodou na počátku řetezců.
hash
založený na hashovací tabulce. Vhodný jen pro testování shody. V současnosti není
u PostgreSQL doporučován (není zcela up to
složené indexy (GIN, GIST)
využívány pro urychlení komplexních relací nad prostorovými daty
a pro fulltext

ÚKOLY
Podívejte se na výhody b
tree na Wikipedii tree na Wikipedii ( https://cs.wikipedia.org/wiki/B strom ) a porovnejte
s využitím hashovací tabulky.

2.2.2 Vícesloupcové a vypočítané indexy
PostgreSQL podporuje i indexy nad vypočítanými hodnotami a vícesloupcové indexy.
CREATE INDEX test2_mm_idx ON test2 (major, minor);
u vícesl
oupcového indexu by měl být nejvíce rozlišující sloupec uveden jako první (tj. např.
příjmení před jménem a to před pohlavím)
Index nad vypočítanou hodnotou lze vytvořit nad libovolným řádkovým výrazem:
CREATE INDEX test1_lower_col1_idx ON test1 (lower(col
1));
nebo
CREATE INDEX people_names ON people ((first_name || ' ' ||
last_name));

2.2.3 Částečné indexy
Nalezení rovnováhy mezi režií přípravy a režií provedení mohou usnadnit částečné indexy, které
indexují jen určitý rozsah hodnot:
CREATE INDEX access_log_clie
nt_ip_ix ON access_log (client_ip)
WHERE NOT (client_ip > inet '192.168.100.0' AND
client_ip < inet '192.168.100.255');
Jiný praktický příklad:
CREATE INDEX orders_unbilled_index ON orders (order_nr)
WHERE billed is not true;

ÚKOLY

1. Jaký rozsah
mají IP adresy indexované v prvním příkladě? Co tento rozsah pravděpodobně
znamená.
2. Použije se či nepoužije index pro následující dotaz?
SELECT *
FROM access_log
WHERE url = '/index.html' AND client_ip = inet '212.78.10.32';
3. Diskutujte nasazení posle
dního praktického příkladu (kdy se vyplatí nasadit tento částečný
index).




