# 05 – (Full)textové vyhledávání

Vyhledávání v textových dokumentch.

[PostgreSQL Ch.12](https://www.postgresql.org/docs/current/textsearch.html)

## Textový dokument

Text v _přirozeném_, lidském jazyce (_přirozené_ x _umělé/formální_ jazyky).

Text je čten z:

- textových polí (sloupců) tabulky
- spojení a agregací textových polí
- vnějších textových souborů – v databázi jsou jen indexy a odkazy

### Vyhledávání

Položit dotaz (query), vyhledat odpovídající dokumenty nebo fragmenty dokumentu.

Typicky v textu vyhledáváme slova, fráze/sousloví, množiny slov, a to

- bez ohledu na gramatický tvar (ohýbání slov)
- s překlepy (přibližné vyhledávání, fuzzy search)
- s přihlédnutím na blízkost (proximitu) slov
- s ohledem na synonyma
- bez ohledu na nevýznamná slova (předložky, spojky, pomocná slovesa, částice)

Výsledek lze řadit podle koeficientu shody (ranking).

### Předzpracování

Dokument musí být předzpracován (preprocessed) a indexován (pomocí podpory externích nástrojů, jako je [ispell](https://en.wikipedia.org/wiki/Ispell)). Provede se:

- tokenizace (rozdělení na tokeny a jejich klasifikace do tříd - čísla, slova, složená slova, emailové adresy, ...)
  - standard parser, custom parser
- konverze na lexémy (transformace slov na základní, společný tvar, slova užitečná pro hledání) pomocí slovníků
  - malá písmena, odstranění přípon, ...
- odstranění stop words (velmi často používaná slova, irrelevantní pro hledání)
- výměna synonym (podle slovníku)
- uložení jako pole normmalitovaných lexémů a jejich pozic (pro proximity search)

## PostgreSQL

### tsvector

Dokument je potřeba konvertovat na typ `tsvector`:

```sql
select 'a fat cat sat on a mat and ate a fat rat';
select 'a fat cat sat on a mat and ate a fat rat'::tsvector;
select to_tsvector('a fat cat sat on a mat and ate a fat rat');
```

### tsquery

Dotaz je potřeba konvertovat na typ `tsquery`:

```sql
select 'cat & rat';
select 'cat & rat'::tsquery;
select to_tsquery('cat & rat');
```

### Dotazy: _match_ operátor @@

Shoduje se text (dokument) s dotazem? Vrací boolean:

```sql
select 'a fat cat sat on a mat and ate a fat rat' @@ 'cat & rat'; -- implicit to_ts...
select 'a fat cat sat on a mat and ate a fat rat'::tsvector @@ 'cat & rat'::tsquery;
select 'cat & rat'::tsquery @@ 'a fat cat sat on a mat and ate a fat rat'::tsvector;

select to_tsvector('fat cats ate fat rats') @@ to_tsquery('fat & rat');
select to_tsquery('fat & rat') @@ to_tsvector('fat cats ate fat rats');
```

Dotazy lze logicky kombinovat:

```sql
select 'fat | rat'::tsquery && 'cat'::tsquery;
select 'fat | rat'::tsquery || 'cat'::tsquery;
select !!'fat | rat'::tsquery;

select 'a fat cat sat on a mat and ate a fat rat' @@ ('fat | rat'::tsquery && 'cat'::tsquery);
select 'a fat cat sat on a mat and ate a fat rat' @@ ('fat | rat'::tsquery && !! 'cat'::tsquery);
```

Dotazy lze použít ve frázích:

```sql
select 'fat'::tsquery <-> 'rat'::tsquery;
select to_tsquery('fat') <-> to_tsquery('rat');

select 'a fat cat sat on a mat and ate a fat rat' @@ ('fat'::tsquery <-> 'rat'::tsquery);
select 'a fat cat sat on a mat and ate a fat rat' @@ ('fat'::tsquery <-> 'cat'::tsquery);
select 'a fat cat sat on a mat and ate a fat rat' @@ ('fat'::tsquery <-> 'sat'::tsquery);
```

Nebo pro zvýraznění textu:

```sql
select ts_headline('a fat cat sat on a mat and ate a fat rat', 'fat & sat');
select ts_headline('english'::regconfig, 'a fat cat sat on a mat and ate a fat rat', 'fat & sat'::tsquery);
```

Obyčejný text lze konvertovat na dotaz:

```sql
select plainto_tsquery('english', 'The Fat Rats...?');
select plainto_tsquery('The Fat Rats...?');

select phraseto_tsquery('english', 'The Fat Rats...?');
select phraseto_tsquery('The Fat Rats...?');

select plainto_tsquery('basque', 'The Fat Rats...?'); -- Hmm...
select plainto_tsquery('czech', 'The Fat Rats...?'); -- Doh!
```

## PostgreSQL – podpora jazyků

```sql
select cfgname FROM pg_ts_config;
```

### Instalace podpory pro češtinu

- https://github.com/char0n/postgresql-czech-fulltext
- https://postgres.cz/wiki/Instalace_PostgreSQL#Instalace_Fulltextu

* [`cp-czech-dict.sh`](../Docker/cp-czech-dict.sh): nahrát slovník
  - `czech.dict`: 300 000 řádek (Burle)
  - `czech.affix`: koncovky
  - `czech.stop`: stop words
* `bash.cz`: otevřít shell (terminál) v kontejneru, pro kontrolu
  - `ls /usr/share/postgresql/17/tsearch_data`

```sql
create text search dictionary czech_spell(template=ispell, dictfile=czech, afffile=czech, stopwords=czech);
create text search configuration czech (copy=english);
alter text search configuration czech alter mapping for word, asciiword with czech_spell, simple;

select cfgname FROM pg_ts_config;

-- test
select * from ts_debug('czech','Příliš žluťoučký kůň se napil čiré vody.');
```

## Příklad textového dokumentu: R.U.R.

https://www.gutenberg.org/cache/epub/13083

### Textový soubor, import

- stáhnout https://www.gutenberg.org/cache/epub/13083/pg13083.txt
- ručně odstranit nepotřebný začátek a konec: [`RUR.txt`](../Docker/texts/RUR.txt)
- zkonvertovat na CSV, např. [`convert.py`](../Docker/convert.py): [`RUR.csv`](../Docker/texts/RUR.csv)
- [`cp-texts.sh`](../Docker/cp-texts.sh): nahrát texty

```sql
create table RUR (
  id serial primary key,
  para text
);

copy RUR from '/home/RUR.csv' with csv;

select count(*) from RUR;
select * from RUR;
```

### Dotazy

```sql
select to_tsvector('czech','roboti');
select to_tsquery('czech','roboti');
select to_tsvector('czech','bezbožné kejkle');
select to_tsquery('czech','bezbožné <-> kejkle');

select * from RUR where to_tsvector('czech',para) @@ to_tsquery('czech','robot');
select * from RUR where to_tsvector('czech',para) @@ to_tsquery('czech','robot & žárovka');
select * from RUR where to_tsvector('czech',para) @@ to_tsquery('czech','robot | žárovka');

select * from RUR where to_tsvector('czech',para) @@ to_tsquery('czech','bezbožný');
select * from RUR where to_tsvector('czech',para) @@ to_tsquery('czech','kejkle');
select * from RUR where to_tsvector('czech',para) @@ to_tsquery('czech','bezbožné <-> kejkle');
```

### Indexace

Pro urychlení fulltextových dokumentů je vhodné použít specializované indexy.

```sql
explain analyze select * from RUR where to_tsvector('czech',para) @@ to_tsquery('czech','robot & žárovka');

--- explain analyze
select
  ts_headline('czech', para, qry, 'StartSel=[, StopSel=]'),
  ts_rank_cd(to_tsvector('czech',para), qry) as rank
from RUR, to_tsquery('czech','roboti | lidé') as qry
where to_tsvector('czech',para) @@ qry
order by rank desc limit 6;

create index idx_rur on RUR using gin(to_tsvector('czech', para));
-- explain alalyze select ...
drop index idx_rur;
```

### Pomocná data

Při častém hledání je vhodné vytvořit pomocný sloupec s předpřipraveným fulltextovým vektorem.

```sql
alter table RUR add column tsv tsvector;
update RUR set tsv = to_tsvector('czech',para);

select * from RUR;

-- explain analyze
select
  ts_headline('czech', para, qry, 'StartSel=[, StopSel=]'),
  ts_rank_cd(tsv, qry) as rank
from RUR, to_tsquery('czech','roboti | lidé') as qry
where tsv @@ qry
order by rank desc limit 6;

alter table RUR drop column tsv;
```

<!-- ## Minulý týden

```sql
create index i1 on weather(temp_lo);
create index i2 on weather(temp_hi);
drop index i1;
drop index i2;

select count(\*) from weather;

explain analyze select temp_hi from weather order by temp_lo;
explain analyze select temp_lo from weather order by temp_lo;
explain analyze select temp_hi from weather where temp_lo < 20 order by temp_lo;
explain analyze select temp_lo from weather where temp_lo < 20 order by temp_lo;
explain analyze select avg(temp_lo) from weather where temp_lo < 20;
explain analyze select avg(temp_hi) from weather where temp_lo < 20;

explain select w1.city_id, w1.date, w1.temp_lo AS low, w1.temp_hi AS high,
w2.city_id, w2.date, w2.temp_lo AS low, w2.temp_hi AS high
FROM weather w1 JOIN weather w2
ON w1.temp_lo < w2.temp_lo AND w2.temp_hi < w1.temp_hi;

explain analyze select w1.city_id, avg(w1.temp_lo) AS low, avg(w1.temp_hi) AS high,
w2.city_id, avg(w2.temp_lo) AS low, avg(w2.temp_hi) AS high
FROM weather w1 JOIN weather w2
ON w1.temp_lo < w2.temp_lo AND w2.temp_hi < w1.temp_hi
GROUP BY w1.city_id, w2.city_id;

``` -->
