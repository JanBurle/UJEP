# 06 – Common Table Expressions

(a.k.a. WITH queries)

WITH: pomocné výrazy, podobné dočasným tabulkám

jeden a více pomocný příkaz WITH + SELECT, INSERT, UPDATE, DELETE, MERGE

připojen k hlavnímu příkazu který jhe také SELECT, INSERT, UPDATE, DELETE, MERGE

místo vnořených SELECT

- [Počasí](./weather.sql)

```sql
select count(*) from weather where temp_hi - temp_lo < 4;
select * from weather where temp_hi - temp_lo < 2 limit 6;

select count(city_id) from weather where avg(temp_hi) - avg(temp_lo) < 4; -- Neeee

select city_id, avg(temp_lo), avg(temp_hi) from weather group by city_id;

create temp table stable_weather as select city_id, avg(temp_lo), avg(temp_hi) from weather group by city_id; -- X
create temp table stable_weather as select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id;
select * from stable_weather limit 6;

select city_id from stable_weather where avg_hi - avg_lo < 4;
drop table stable_weather;

select * from (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id);
select city_id from (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id) where avg_hi - avg_lo < 4;
select name from (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id) join city on id=city_id where avg_hi - avg_lo < 4;
```

```sql
WITH avg_weather AS (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id)
select name from avg_weather join city on id=city_id where avg_hi - avg_lo < 4;

WITH
  avg_weather AS (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id),
  stable_weather as (select * from avg_weather where avg_hi - avg_lo < 4)
select name from stable_weather join city on id=city_id;
```

---

rekurzivní WITH
nemožné ve standardním SQL
lze odkázat na svůj vlastní výstup

```sql
with recursive t(n) as (
values (1)
union all
select n+1 from t where n < 100
)
select sum(n) from t;
```

obecně: nerekurzivní term, pak UNION nebo UNION ALL, pak rekurzivní term, který odkáže na svůj vlastní výstup

Postup: vyhodnoť nerekurzivní term, pokud UNION xALL, zahoď duplikáty, dej zbytek k výsledku a do dočasné ppracovní tabulky

dokud pracovní tabulka je neprázdná, opakuj:
vyhodnoť rekurzivní term, self-reference <-- pracovní tabulka
pokud UNION, vyřaď duplikáty, zbytek přidej do výsledku a mezi-tabulky
přesuň obsah mezi-tabulky do pracovní tabulky, vyprázdni mezi-tabulky

(vnitřně jde o iteraci, ne rekurzi)

Nejčastěji používáno pro reprezentaci hierarchií a stromů

Procházení stromem do hloubky (depth-first) nebo do šířky (breadth-first)
vypočítávat ordering column, sort (skutečné pořadí procházení je závislé na implementaci)

```sql
with recursive search_tree(id, link, data) as (
select t.id, t.link, t.data
from tree t
union all
select t.id, t.link, t.data
from tree t, search_tree st
where t.id = st.link
)
select * from search_tree;
```

depth-first

```sql
WITH RECURSIVE search_tree(id, link, data, path) AS (
SELECT t.id, t.link, t.data, ARRAY[t.id]
FROM tree t
UNION ALL
SELECT t.id, t.link, t.data, path || t.id
FROM tree t, search_tree st
WHERE t.id = st.link
)
SELECT * FROM search_tree ORDER BY path;
```

breadth-first

```sql
WITH RECURSIVE search_tree(id, link, data, depth) AS (
SELECT t.id, t.link, t.data, 0
FROM tree t
UNION ALL
SELECT t.id, t.link, t.data, depth + 1
FROM tree t, search_tree st
WHERE t.id = st.link
)
SELECT * FROM search_tree ORDER BY depth;
```

note: skutečné pořadí procházení nedefinované, pořadí záznamů v každé úrovni také

Vestavěná syntaxe

```sql
WITH RECURSIVE search_tree(id, link, data) AS (SELECT t.id, t.link, t.data
FROM tree t
UNION ALL
SELECT t.id, t.link, t.data
FROM tree t, search_tree st
WHERE t.id = st.link
) SEARCH DEPTH FIRST BY id SET ordercol
SELECT * FROM search_tree ORDER BY ordercol;
```

```sql
WITH RECURSIVE search_tree(id, link, data) AS (
SELECT t.id, t.link, t.data
FROM tree t
UNION ALL
SELECT t.id, t.link, t.data
FROM tree t, search_tree st
WHERE t.id = st.link
) SEARCH BREADTH FIRST BY id SET ordercol
SELECT * FROM search_tree ORDER BY ordercol;

```

Detekce cyklů

rekurzivní část musí eventuelně vrátit nic, jinak nekonečný cyklus

někdy pomůže UNION xALL
někdy ale je výstup neduplikátní a je potřeba duplicitu kontrolovat jen na několika polích: std metod je počítat pole již navštívených hodnot. Např.

```sql
WITH RECURSIVE search_graph(id, link, data, depth) AS (
SELECT g.id, g.link, g.data, 0
FROM graph g
UNION ALL
SELECT g.id, g.link, g.data, sg.depth + 1
FROM graph g, search_graph sg
WHERE g.id = sg.link
)
SELECT * FROM search_graph;
```

to je depth a tak UNION nestačí

````sql
WITH RECURSIVE search_graph(id, link, data, depth, is_cycle, path)
AS (
SELECT g.id, g.link, g.data, 0,
false,
ARRAY[g.id]
FROM graph g
UNION ALL
SELECT g.id, g.link, g.data, sg.depth + 1,g.id = ANY(path),
path || g.id
FROM graph g, search_graph sg
WHERE g.id = sg.link AND NOT is_cycle
)
SELECT * FROM search_graph;```
````

path také je dobrý výsledek

Vestavěná syntaxe

```sql
WITH RECURSIVE search_graph(id, link, data, depth) AS (
SELECT g.id, g.link, g.data, 1
FROM graph g
UNION ALL
SELECT g.id, g.link, g.data, sg.depth + 1
FROM graph g, search_graph sg
WHERE g.id = sg.link
) CYCLE id SET is_cycle USING path
SELECT * FROM search_graph;
```

CYCLE <column list for detection> SET <column name whether detected> USING <column for tracking>

Useful trick for testing, not production:

```sql
WITH RECURSIVE t(n) AS (
SELECT 1
UNION ALL
SELECT n+1 FROM t
)
SELECT n FROM t LIMIT 100;
```

planner/optimizer zvolí zda WITH se materializuje, nebo ne (with je folded into query), override (NOT) MATERIALIZED

dále: WITH s DELETE, UPDATE, ....
