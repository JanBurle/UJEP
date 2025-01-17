# 04 – Indexy a analýza dotazů

[PostgreSQL Ch.11](https://www.postgresql.org/docs/current/indexes.html)

## Indexy:

- zajistí referenční integritu
- urychlí vyhledávaní záznamů (řádek tabulky) v databázi (pro: SELECT, UPDATE, DELETE, JOIN)
- data navíc (podmnožina dat): zvýší náklady (overhead) databáze – index je nutno vytvořit a udržovat, podobně jako index na konci knihy.
- kompromis prostor / čas

Při selekci řádků (`SELECT ... WHERE ...`) bez indexů je nutné projít (scan) celou tabulku (v čase _O(n)_). Pokud ale existuje odpovídají index nad poli použitými v klauzuli `WHERE ...`, lze záznamy vyhledat rychleji, typicky pomocí vyhledávacího stromu (search tree), v čase _O(log n)_.

Podobné urychlení nastane při spojování (JOIN) a třídění (ORDER BY).

- ? Indexy udržovat nebo smazat (DROP) a znovu vytvořit ?

### Typy indexů

#### [B-stromy](https://cs.wikipedia.org/wiki/B-strom) (default)

```sql
CREATE INDEX name ON table(column);
```

Vhodné pro:

- porovnávání <, <=, =, >=, >, BETWEEN, IN, IS (NOT) NULL, LIKE 'xxx%'
- třídění ORDER BY

#### [Haš](https://cs.wikipedia.org/wiki/Ha%C5%A1ovac%C3%AD_funkce)

Založený na hašovacích tabulkách.

```sql
CREATE INDEX name ON table USING HASH (column);
```

- levnější než B-stromy
- vhodné jen pro =

#### GIST, SP-GIST (Geographic Information Systems Technology)

- pro prostorové souřadnice, hledání sousedů
- [quadtree](https://en.wikipedia.org/wiki/Quadtree), [octtree](https://en.wikipedia.org/wiki/Octree)

#### GIN (Generalized INverted index)

Fulltext search, LIKE, apod.

[Pro zvídavé](https://pganalyze.com/blog/gin-index)

### Indexy nad více sloupci (multicolumn, vícesloupcové)

```sql
CREATE INDEX name ON table(col1, col2, ...);
CREATE INDEX name ON table(col1 DESC, col2 NULLS FIRST/LAST, ...);
```

Nejvíce rozlišující sloupec by měl být uveden první, atd.

- Pro dotazy typu

```sql
... WHERE col1 op ... AND col2 op ... AND ...);
```

a

```sql
... ORDER BY col1, col2, ...);
```

(zleva doprava: col1, col2, ...)

### Kombinace indexů

AND: lze použít jeden index:

```sql
... WHERE ... AND ...;
```

OR: vyžaduje více indexů (nebo jeden index vícekrát):

```sql
... WHERE ... OR ...;
```

### Unikátní indexy

```sql
CREATE UNIQUE INDEX name ON ... [ NULLS [ NOT ] DISTINCT ];
```

### Indexy nad výrazy (vypočítané indexy)

Pokud je v dotazech např. funkce:

```sql
... WHERE lower(col) = 'value';
```

Pak je užitečný index:

```sql
CREATE INDEX name ON table(lower(col));
```

Nebo, jestliže je dotaz:

```sql
SELECT * FROM people WHERE (first_name || ' ' || last_name) = 'John Smith';
```

bude užitečný index

```sql
CREATE INDEX names ON people ((first_name || ' ' || last_name));
```

### Částečné indexy (partial indexes)

Kompromis mezi režií přípravy a režií provedení. Indexují jen určitý rozsah hodnot:

```sql
CREATE INDEX name ON table(col) WHERE ... col ...
```

### Dotazy jen nad indexy

```sql
CREATE INDEX name ON table(col1, col2, ...)
```

```sql
SELECT col1, col2 FROM name WHERE ... col1 ... col2 ...
```

## Optimalizace dotazů

Zohledňuje se velikost zpracovávaných tabulek, včetně dočasných
tabulek vzniklých během provádění složitějších dotazů. Velikost tabulky je především dána počtem řádků (počet sloupců je v praxi většinou omezený):

- microtabulky = tabulky s několika málo řádky a sloupci
  - optimalizace je kontraproduktivní
- mezotabulky = desítky až tisíce řádků (jeden diskový blok / resp. stránka paměti)
  - bitmap scan, hash join
- macrotabulky
  - index scan, merge join

## Prováděcí plán

Plánovač v DBS připraví tzv. prováděcí plán dotazu. To je kritická operace. Rozhoduje se mj. podle velikosti tabulek. Rozsah průběžně vytvářených tabulek lze předem určit jen obtížně (výjimka: agregace, dotazy se sekcí LIMIT), proto se běžně jen odhaduje:

- z velikosti fyzických tabulek
- z empiricky zjištěných rozdělení pravděpodobnosti
- z výsledků předchozích obdobných dotazů

Dobré odhady vyžadují průběžnou analýzu dat a provádění reálně využívaných dotazů (tzv. postupná akomodace).

## Analýza dotazů

Jak se zjistí jaký plán byl použit:

```sql
EXPLAIN [ANALYZE] dotaz
```

Vypíše detailní plán s uvedením použitých mechanismů, odhadovanou cenou a počtem řádků tabulek.

(ANALYZE = vykoná plán a údaje o reálném provedení přidá do výstupu pro srovnání.)

EXPLAIN zobrazí plán.

## Praktický příklad

Dvě verze tabulek:

1. [tabulky bez indexů](./data1.sql)
1. [tabulky s hlavními PK/FK](./data2.sql)

Prozkoumejte:

```sql
select count(*) from city;
explain select count(*) from city;
explain analyze select count(*) from city;

select count(*) from city where id='oo';
explain select count(*) from city where id='oo';
explain analyze select count(*) from city where id='oo';

select count(*) from city cross join weather;
explain select count(*) from city cross join weather;
explain analyze select count(*) from city cross join weather;

select count(*) from city join weather on city.id=weather.city_id;
explain select count(*) from city join weather on city.id=weather.city_id;
explain analyze select count(*) from city join weather on city.id=weather.city_id;

select count(*) from city join weather on city.id=weather.city_id where city.id='oo';
explain select count(*) from city join weather on city.id=weather.city_id where city.id='oo';
explain analyze select id from city join weather on city.id=weather.city_id where city.id='oo';
vacuum analyze;

explain analyze select avg(temp_lo) from weather where temp_hi < 20;
explain analyze select avg(temp_hi) from weather where temp_lo < 20;
CREATE INDEX idx_temp_lo on weather(temp_lo);
explain analyze select avg(temp_hi) from weather where temp_hi < 20;
explain analyze select avg(temp_lo) from weather where temp_lo < 20;

explain analyze select temp_hi from weather where temp_lo < 20;
explain analyze select temp_lo from weather where temp_hi < 20;

explain analyze select temp_hi from weather order by temp_lo;
explain analyze select temp_lo from weather order by temp_lo;
explain analyze select temp_lo from weather order by temp_hi;

explain SELECT w1.city_id, w1.temp_lo AS low, w1.temp_hi AS high,
       w2.city_id, w2.temp_lo AS low, w2.temp_hi AS high
  FROM weather w1 JOIN weather w2
  ON w1.temp_lo < w2.temp_lo AND w2.temp_hi < w1.temp_hi;

explain SELECT w1.city_id, avg(w1.temp_lo) AS low, avg(w1.temp_hi) AS high,
       w2.city_id, avg(w2.temp_lo) AS low, avg(w2.temp_hi) AS high
  FROM weather w1 JOIN weather w2
  ON w1.temp_lo < w2.temp_lo AND w2.temp_hi < w1.temp_hi
  GROUP BY w1.city_id, w2.city_id;

-- indexy ano/ne
create index i1 on weather(temp_lo);
create index i2 on weather(temp_hi);
drop index i1;
drop index i2;
```
