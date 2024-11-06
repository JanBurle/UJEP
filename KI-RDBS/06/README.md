# 06 – Common Table Expressions

[PostgreSQL Ch.7.8](https://www.postgresql.org/docs/current/queries-with.html)

A.K.A _WITH_ dotazy

Klauzule WITH: pomocné výrazy, podobné dočasným tabulkám. WITH + jeden nebo více pomocných příkazů SELECT, INSERT, UPDATE, DELETE nebo MERGE.

Připojeno k hlavnímu příkazu SELECT, INSERT, UPDATE, DELETE nebo MERGE.

Použití: především místo vnořených SELECT.

Ukázková data: [počasí](./weather.sql).

```sql
select count(*) from city;
select count(*) from weather;
select * from city;
select * from weather;
```

Tradiční přístup k datům:

```sql
-- počet záznamů s malým rozsahem teplot
select count(*) from weather where temp_hi - temp_lo < 4;
-- prvních několik záznamů
select * from weather where temp_hi - temp_lo < 4 order by date limit 6;

-- pokus: spočítej města s malým rozsahem průměrných teplot - nelze
select count(city_id) from weather where avg(temp_hi) - avg(temp_lo) < 4;

-- tak tedy jinak: města a jejich průměrné teploty - lze
select city_id, avg(temp_lo), avg(temp_hi) from weather group by city_id;

-- dobře, spočítám a uložím do dočasné tabulky
drop table if exists avg_weather;
create temp table avg_weather as select city_id, avg(temp_lo), avg(temp_hi) from weather group by city_id; -- nee
-- aha, musím pojmenovat sloupce unikátně
create temp table avg_weather as select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id;
-- mám to:
select * from avg_weather limit 6;
-- a nyní mohu vybírat města podle rozsahu průměrných teplot
select city_id, avg_hi - avg_lo from avg_weather where avg_hi - avg_lo < 4;

-- místo dočasné tabulky mohu použít vnořený select
-- města a jejich průměrné teploty
select * from (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id);
-- a nyní mohu vybírat města podle rozsahu průměrných teplot
select city_id, avg_hi - avg_lo from
  (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id)
  where avg_hi - avg_lo < 4;
-- a připojit jména měst
select name, avg_hi - avg_lo from
  (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id)
  join city on id=city_id where avg_hi - avg_lo < 4;
```

Pomocí CTE:

```sql
-- jeden pomocný select
with
  avg_weather as (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id)
select name, avg_hi - avg_lo from avg_weather join city on id=city_id where avg_hi - avg_lo < 4;

-- dva pomocné selecty, druhý závisí na prvním
with
  avg_weather as (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id),
  stable_weather as (select * from avg_weather where avg_hi - avg_lo < 4)
select name, avg_hi - avg_lo from stable_weather join city on id=city_id;
```

Porovnáme plány - jsou stejné:

```sql
explain analyze
select name, avg_hi - avg_lo from
  (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id)
  join city on id=city_id where avg_hi - avg_lo < 4;

explain analyze
with
  avg_weather as (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id)
select name, avg_hi - avg_lo from avg_weather join city on id=city_id where avg_hi - avg_lo < 4;

explain analyze
with
  avg_weather as (select city_id, avg(temp_lo) as avg_lo, avg(temp_hi) as avg_hi from weather group by city_id),
  stable_weather as (select * from avg_weather where avg_hi - avg_lo < 4)
select name, avg_hi - avg_lo from stable_weather join city on id=city_id;
```

## Rekurzivní WITH dotazy

- nemožné ve standardním SQL
- lze odkázat na svůj vlastní výstup

```sql
-- řada čísel: 1, 2, 3, ..
with recursive t(n) as
  (values (1)                      -- nerekurzivní výraz
    union all                      -- UNION (ALL)
   select n+1 from t where n < 3)  -- rekurzivní výraz odkazující sám na sebe
select n from t;

-- součet
with recursive t(n) as
  (values (1) union all select n+1 from t where n < 3)
select sum(n) from t;
```

Algoritmus:

1. Vyhodnoť nerekurzivní term. Pokud je UNION bez _ALL_, vyřaď duplikáty. Zbytek záznamů dej do výsledku a do dočasné _pracovní_ tabulky.

2. Dokud je pracovní tabulka neprázdná, opakuj:

- Vyhodnoť rekurzivní term, self-reference odkazuje na pracovní tabulku. Pokud je UNION bez ALL, vyřaď duplikáty. Přidej zbylé k výsledku a vlož jako nový obsah do pracovní tabulky.

Poznámka: vnitřně je proces iterativní, nikoli rekurzivní.

### Hierarchie

Nejčastěji je rekurzivní CTE používáno při reprezentaci hierarchií, stromů a grafů.

Příklad – vytvoř tabulka uzlů stromů:

```sql
drop table if exists tree;
create table tree (
  id serial primary key,               -- node id
  up integer references tree(id) NULL, -- parent node id
  name text
);

create index idx_up on tree(up);
```

Vlož testovací data, tři stromy, tři úrovně:

```sql
do $$
declare
  i1 integer; i2 integer; i3 integer;
begin
  -- first level
  for i1 in 1..3 loop
    insert into tree (id, up, name) values (i1, null, 'Node ' || i1);
  end loop;

  -- second level
  for i1 in 1..3 loop
    for i2 in 1..3 loop
      insert into tree (id, up, name) values (i1*10+i2, i1, 'Node ' || i1 || i2);
    end loop;
  end loop;

  -- third level
  for i1 in 1..3 loop
    for i2 in 1..3 loop
      for i3 in 1..3 loop
        insert into tree (id, up, name) values (i1*100+i2*10+i3, i1*10+i2, 'Node ' || i1 || i2 || i3);
      end loop;
    end loop;
  end loop;
end $$;

select * from tree;
```

### Procházení stromem

Vyhledání všech uzlů ve stromech:

```sql
with recursive search_tree(id, up, name) as
  (select t.id, t.up, t.name from tree t where up is null
     union all
   select t.id, t.up, t.name from tree t, search_tree st where t.up = st.id)
select * from search_tree;
```

Vyhledání všech uzlů ve stromu s daným id kořene:

```sql
with recursive search_tree(id, up, name) as
  (select t.id, t.up, t.name from tree t where id = 1
  -- nebo> (select id from tree where up is null order by id limit 1)
     union all
   select t.id, t.up, t.name from tree t, search_tree st where t.up = st.id)
select * from search_tree;
```

Strom lze procházet do hloubky (depth-first) nebo do šířky (breadth-first). Pořadí je určeno obsahem vypočítaného sloupci. Skutečné pořadí procházení je závislé na implementaci.

#### depth-first

```sql
with recursive search_tree(id, up, name, path) as
  (select t.id, t.up, t.name, array[t.id] from tree t where id = 1
     union all
   select t.id, t.up, t.name, path || t.id from tree t, search_tree st where t.up = st.id)
select * from search_tree order by path;
```

#### breadth-first

```sql
with recursive search_tree(id, up, name, depth) as
  (select t.id, t.up, t.name, 0 from tree t where id = 1
     union all
   select t.id, t.up, t.name, depth+1 from tree t, search_tree st where t.up = st.id)
select * from search_tree order by depth, -- depth first
                                   id;    -- order nodes of the same depth
```

Skutečné pořadí procházení je nedefinované, pořadí záznamů v každé úrovni také.

### Vestavěná syntaxe

#### depth-first

```sql
with recursive search_tree(id, up, name) as
  (select t.id, t.up, t.name from tree t where id = 1
     union all
   select t.id, t.up, t.name from tree t, search_tree st where t.up = st.id)
search depth first by id set order_col
select * from search_tree order by order_col;
```

#### breadth-first

```sql
with recursive search_tree(id, up, name) as
  (select t.id, t.up, t.name from tree t where id = 1
     union all
   select t.id, t.up, t.name from tree t, search_tree st where t.up = st.id)
search breadth first by id set order_col
select * from search_tree order by order_col;
```

### Detekce cyklů

Rekurzivní část musí eventuelně vrátit prázdnou množinu řádků, jinak nastane nekonečný cyklus.

```sql
update tree set up=111 where id=1; -- cyklus
```

Někdy pomůže UNION bez ALL:

```sql
with recursive search_tree(id, up, name) as
  (select t.id, t.up, t.name from tree t where id = 1
     union -- all
   select t.id, t.up, t.name from tree t, search_tree st where t.up = st.id)
select * from search_tree;
```

Někdy ale je výstup neduplikátní, např. depth-first:

```sql
with recursive search_tree(id, up, name, path) as
  (select t.id, t.up, t.name, array[t.id] from tree t where id = 1
     union -- all
   select t.id, t.up, t.name, path || t.id from tree t, search_tree st where t.up = st.id)
select * from search_tree order by path;
```

Pak je potřeba duplicitu kontrolovat jen na několika polích. Standardní metoda je kontrolovat cestu již navštívených hodnot:

```sql
with recursive search_tree(id, up, name, path, is_cycle) as
  (select t.id, t.up, t.name, array[t.id], false from tree t where id = 1
     union
   select t.id, t.up, t.name, path || t.id,
   t.id = ANY(path) -- cycle detection
   from tree t, search_tree st where t.up = st.id and not is_cycle)
select * from search_tree order by path;
```

### Vestavěná syntaxe

```
CYCLE <column list for detection> SET <column name whether detected> USING <column for tracking>
```

```sql
with recursive search_tree(id, up, name) as
  (select t.id, t.up, t.name from tree t where id = 1
     union all
   select t.id, t.up, t.name from tree t, search_tree st where t.up = st.id)
search breadth first by id set order_col -- or: depth
cycle id set is_cycle using path
select * from search_tree order by order_col;
```

Implicitně depth-first:

```sql
with recursive search_tree(id, up, name) as
  (select t.id, t.up, t.name from tree t where id = 1
     union all
   select t.id, t.up, t.name from tree t, search_tree st where t.up = st.id)
cycle id set is_cycle using path
select * from search_tree order by path;
```
