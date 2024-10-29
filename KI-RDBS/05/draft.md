## Vyhledávání v textových dokumentech

- Textový dokument: text v přirozeném (lidském) jazyce

  - _přirozený_ x _umělý_ jazyk

- Položit _dotaz_ (query), vyhledat dokumenty, seřadit podle podobnosti (similarity).

- Typicky: vyhledat v textu slova, fráze/sousloví, množiny slov

  - bez ohledu na gramatický tvar (ohýbání slov)
  - s překlepy (fuzzy search)
  - podle blízkosti (proximity) slov
  - s ohledem na synonyma
  - bez ohledu na nevýznamná slova (předložky, spojky, pomocná slovesa, částice)
  - řazení podle koeficientu shody (ranking)

- Dokument:

  - textová pole v tabulce (sloupce), jejich spojení a agregace
  - vnější textové soubory, v db index info

- Dokument musí být předzpracován (preprocessed) a indexován (pomocí podpory externích nástrojů: cspell, ispell, hunspell)
  - tokenizace (rozdělení do tokenů a jejich klasifikace do tříd - čísla, slova, složená slova, emailové adresy, ...)
    - standard parser, custom parser
  - konverze na lexémy (transformace slov na základní, společný tvar, slova užitečná pro hledání) pomocí slovníků
    - malá písmena, odstranění přípon
  - odstranění stop words (velmi často používaná slova)
  - nalezení synonym (slovníky)
  - uložit jako pole normmalitovaných lexémů a jejich pozic (proximity search)

data type tsvector, tsquery match operator @@
dokument konvertovat na tsvector

SELECT 'a fat cat sat on a mat and ate a fat rat'::tsvector @@ 'cat
& rat'::tsquery;
?column?

SELECT 'fat & cow'::tsquery @@ 'a fat cat sat on a mat and ate a
fat rat'::tsvector;
?column?

SELECT to_tsvector('fat cats ate fat rats') @@ to_tsquery('fat &
rat');
?column?

tsvector @@ tsquery
tsquery @@ tsvector
text @@ tsquery
text @@ text

tsvector @@ tsquery → boolean
tsquery @@ tsvector → boolean
Does tsvector match tsquery? (The arguments can be given in either order.)
to_tsvector('fat cats ate rats') @@ to_tsquery('cat & rat')
→ t

text @@ tsquery → boolean
Does text string, after implicit invocation of to_tsvector(), match tsquery?
'fat cats ate rats' @@ to_tsquery('cat & rat') → t

tsquery && tsquery → tsquery
ANDs two tsquerys together, producing a query that matches documents that match
both input queries.
'fat | rat'::tsquery && 'cat'::tsquery → ( 'fat' | 'rat' ) &
'cat'

tsquery || tsquery → tsquery
ORs two tsquerys together, producing a query that matches documents that match either
input query.
'fat | rat'::tsquery || 'cat'::tsquery → 'fat' | 'rat' |
'cat'

!! tsquery → tsquery
Negates a tsquery, producing a query that matches documents that do not match the
input query.
!! 'cat'::tsquery → !'cat'

tsquery <-> tsquery → tsquery
Constructs a phrase query, which matches if the two input queries match at successive
lexemes.
to_tsquery('fat') <-> to_tsquery('rat') → 'fat' <-> 'rat'

plainto_tsquery ( [ config regconfig, ] query text ) → tsquery
Converts text to a tsquery, normalizing words according to the specified or default
configuration
plainto_tsquery('english', 'The Fat Rats') → 'fat' & 'rat'

phraseto_tsquery ( [ config regconfig, ] query text ) → tsquery
Converts text to a tsquery, normalizing words according to the specified or default
configuration. Any punctuation in the string is ignored (it does not determine query operators).
The resulting query matches phrases containing all non-stopwords in the text.
phraseto_tsquery('english', 'The Fat Rats') → 'fat' <->
'rat'
phraseto_tsquery('english', 'The Cat and Rats') → 'cat' <2>
'rat'

to_tsquery ( [ config regconfig, ] query text ) → tsquery
Converts text to a tsquery, normalizing words according to the specified or default
configuration. The words must be combined by valid tsquery operators.
to_tsquery('english', 'The & Fat & Rats') → 'fat' & 'rat'

to_tsvector ( [ config regconfig, ] document text ) → tsvector
Converts text to a tsvector, normalizing words according to the specified or default
configuration. Position information is included in the result.
to_tsvector('english', 'The Fat Rats') → 'fat':2 'rat':3

ts_headline ( [ config regconfig, ] document text, query tsquery [, options
text ] ) → text

Displays, in an abbreviated form, the match(es) for the query in the document, which
must be raw text not a tsvector. Words in the document are normalized according to
the specified or default configuration before matching to the query. Use of this function
is discussed in Section 12.3.4, which also describes the available options.
ts_headline('The fat cat ate the rat.', 'cat') → The fat
<b>cat</b> ate the rat.

SELECT title
FROM pgweb
WHERE to_tsvector('english', body) @@ to_tsquery('english',
'friend');

CREATE INDEX pgweb_idx ON pgweb USING GIN (to_tsvector('english',
body));

ALTER TABLE pgweb
ADD COLUMN textsearchable_index_col tsvector
GENERATED ALWAYS AS (to_tsvector('english',
coalesce(title, '') || ' ' || coalesce(body, ''))) STORED;
CREATE INDEX textsearch_idx ON pgweb USING GIN
(textsearchable_index_col);
SELECT title
FROM pgweb
WHERE textsearchable_index_col @@ to_tsquery('create & table')
ORDER BY last_mod_date DESC
LIMIT 10;

SELECT to_tsvector('english', 'a fat cat sat on a mat - it ate a
fat rats');

SELECT title, ts_rank_cd(textsearch, query) AS rank
FROM apod, to_tsquery('neutrino|(dark & matter)') query
WHERE query @@ textsearch
ORDER BY rank DESC
LIMIT 10;

SELECT ts_headline('english',
'The most common type of search
is to find all documents containing given query terms
and return them in order of their similarity to the
query.',
to_tsquery('english', 'query & similarity'));

## PostgreSQL

## Podpora řady jazyků

## Instalace podpory pro češtinu

CREATE TEXT SEARCH DICTIONARY cspell
(template=ispell, dictfile = czech, afffile=czech, stopwords=czech);
CREATE TEXT SEARCH CONFIGURATION cs (copy=english);
ALTER TEXT SEARCH CONFIGURATION cs
ALTER MAPPING FOR word, asciiword WITH cspell, simple;

select \* from ts_debug('cs','Příliš žluťoučký kůň se napil žluté vody');

## Tsvector

4.1 Tsvector
výsledkem předzpracování je tzv. tsvector
(základní tvary slov + pozice +
select to_tsvector('cs', 'Jiří Fišer, Dukelských hrdinů 35');
"'35':5 'dukelský':3 'fišer':2 'hrdina':4 'jiří':1"

## Tsquery

předzpracovaný fulltextový dotaz,
který se tokenizuje a lematizuje (odstranění stopwords,
interpunkce)
plainto*tsquery('cs', 'kočka a pes')
lze přím
o využít i dotazovací jazyk (mezery mezi slovy nelze použít):
to_tsquery('cs', 'kočka | pes')
podporované operátory &, \*, ! a lze vyjádřit i hledaný prefix:
to*_\_tsquery('cs', 'krok:_') najde i krok, kroky apod.

## Dotazy

základem fulltextových dotazů je aplikace dotazu
tsquery na vektor textových dat tsvector.
to_tsvector('cs',...) @@ to_tsquery('cs',...)
tato konstrukce se využívá nejčastěji v sekci WHERE:
SELECT chapter, paragraph, content
FROM svejk
WHERE to_tsvecto r('cs',content) @@ to_tsquery('cs','zeman');
Nainstalujte si databázi svejk.sql, která obsahuje všechny odstavce Haškova Švejka,

Vytvořte dotaz, který vypíše pro každou kapitolu počet odstavců, které obsahují (v různých tvarech)
jméno hlavního hrdiny.

## Složitější dotazy

komplexnější fulltextové dotazy mohou kvantifikovat shodu na základě indexů:
 ts_rank funkce počtu výskytů
 ts_rank_cd funkce tzv. cover density
a vizuálně vyznačovat nalezené shody (ts_headline)

SELECT
ts_headline ((' content query 'StartSel={,
ts_rank_cd to_tsvector ((' content query AS rank
FROM
svejk to_tsquery (('baloun & AS query
WHERE
query to_tsvector ((' content
ORDER
BY rank DESC
LIMIT 4¨

## Indexy

Pro urychlení fulltextových dokumentů je téměř nezbytné (v PostgreSQL však nikoliv nutné)
používat sp ecializované indexy.
CREATE INDEX svejk_idx ON svejk USING gin(to_tsvector('cs',
content));

při častém využívání dokumentu (včetně složených) je vhodné vytvořit pomocný sloupec
s předpřipraveným fulltextovým vektorem.

ALTER
TABLE pgweb ADD COLUMN tex tsearchable_index_col tsvector
UPDATE
pgweb SET textsearchable_index_col =
to_tsvector( tsvector(' english', coalesce ( title,'''') || '
|| coalesce body

EXPLAIN ANALYZE

import csv
import re

# Step 1: Download the text file (manually or using wget)

# wget -O gutenberg.txt "http://www.gutenberg.org/files/1342/1342-0.txt"

# Step 2: Read the text file

with open('C:\\cygwin64\\home\\jan\\GH\\UJEP\\KI-RDBS\\Docker\\texts\\RUR.txt', 'r', encoding='utf-8') as file:
content = file.read()

# Step 3: Split content by blank lines

content = re.sub(r'\n\n+', '\n\n', content)
entries = content.split('\n\n')

def sanitize(entry):
entry = re.sub(r'\s+', ' ', entry)
entry = entry.replace('\n', ' ')
return entry.strip()

# Step 4: Write the entries to a CSV file

with open('C:\\cygwin64\\home\\jan\\GH\\UJEP\\KI-RDBS\\Docker\\texts\\RUR.csv', 'w', newline='', encoding='utf-8') as csvfile:
writer = csv.writer(csvfile)
writer.writerow(['id', 'content']) # Write header
for idx, entry in enumerate(entries, start=1):
writer.writerow([idx, sanitize(entry)])

## print("Conversion to CSV completed.")

--- czech?

SELECT cfgname FROM pg_ts_config;

create text search dictionary czech_spell(template=ispell, dictfile=czech, afffile=czech, stopwords=czech);
create text search configuration czech (copy=english);
alter text search configuration czech alter mapping for word, asciiword with czech_spell, simple;

R.U.R.
https://www.gutenberg.org/ebooks/13083

---

SELECT cfgname FROM pg_ts_config;

create text search dictionary czech_spell(template=ispell, dictfile=czech, afffile=czech, stopwords=czech);
create text search configuration czech (copy=english);
alter text search configuration czech alter mapping for word, asciiword with czech_spell, simple;

SELECT cfgname FROM pg_ts_config;
select to_tsvector('czech'::regconfig, 'test');

drop table RUR;
CREATE TABLE RUR (
id SERIAL PRIMARY KEY,
para TEXT
);

copy RUR from '/home/RUR.csv' with csv;

select load_csv_file('myTable','/home/RUR.txt',24)

------ once more
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

explain SELECT w1.city_id, w1.date, w1.temp_lo AS low, w1.temp_hi AS high,
w2.city_id, w2.date, w2.temp_lo AS low, w2.temp_hi AS high
FROM weather w1 JOIN weather w2
ON w1.temp_lo < w2.temp_lo AND w2.temp_hi < w1.temp_hi;

explain analyze SELECT w1.city_id, avg(w1.temp_lo) AS low, avg(w1.temp_hi) AS high,
w2.city_id, avg(w2.temp_lo) AS low, avg(w2.temp_hi) AS high
FROM weather w1 JOIN weather w2
ON w1.temp_lo < w2.temp_lo AND w2.temp_hi < w1.temp_hi
GROUP BY w1.city_id, w2.city_id;
