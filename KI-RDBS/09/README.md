# 09 – Kurzory, výjimky

## Kurzory

Dotazy vrací potencielně mnoho řádků:

```sql
select * from city;
```

Místo přenosu celého výsledku (tabulky) lze otevřít kurzor ("portál", jakýsi stav dotazu) a záznamy načítat postupně pomocí FETCH (a také te přeskakovat pomocí MOVE).

```sql
-- neefektivní kód, jen jako příklad
create or replace function count_cities(like_name text = '%')
  returns integer as $$
declare
  city_cursor cursor for select id, name from city where name like like_name;
  city_record record;
  cnt integer;
begin
  cnt = 0;
  open city_cursor;
  loop
    fetch next from city_cursor into city_record;
    exit when not found;
    -- city with enough weather records
    if 20 < (select count(*) from weather where city_id=city_record.id) then
      cnt = cnt + 1;
    end if;
  end loop;

  close city_cursor;
  return cnt;
end; $$ language plpgsql;

select count_cities();
select count_cities('%');
select count_cities('Ci%Z');
```

## Chyby, výjimky a jejich obsluha

### Signalizace a obsluha chyb

- funkce vrací chybový kód (C, Unix: errno)
- funkce vrací hodnotu a chybový kód
- nastává výjimka

Otázky: Víme, jaké chyby mohou nastat? Lze chybovou situaci ignorovat?

### SQL: výjimky

Ukázková funkce s kurzorem:

```sql
-- průměrná teplota v městech s vybranými id
create or replace function avg_temp_lo(like_id text = '%')
  returns real as $$
declare
  weather_cursor cursor for select city_id, temp_lo, temp_hi from weather;
  weather_record record;
  cnt integer;
  sum real;
begin
  cnt = 0; sum = 0;

  open weather_cursor;
  loop
    fetch next from weather_cursor into weather_record;
    exit when not found;

    -- if not (weather_record.temp_lo <= weather_record.temp_hi) then
    --  raise exception 'Invalid temperature data: %', weather_record;
    -- end if;

    if weather_record.city_id like like_id then
      cnt = cnt + 1;
      sum = sum + weather_record.temp_lo;
    end if;
  end loop;

  close weather_cursor;
  return sum / cnt;
-- exception
--  when division_by_zero then
--    return null;
--  when others then
--    ...;
end; $$ language plpgsql;

select avg_temp_lo();
select avg_temp_lo('%');
select avg_temp_lo('%z');
select avg_temp_lo('%Z'); -- error
-- add exception handler
-- add raise exception
```

<!--

```sql
DECLARE
curs1 refcursor; -- with any query
curs2 CURSOR FOR SELECT * FROM tenk1; -- with a bound query
curs3 CURSOR (key integer) FOR SELECT * FROM tenk1 WHERE
unique1 = key; -- wit a parametrized query
```

Otevřít kurzor - vytvoří _portál_ (status dotazu)

```
OPEN unbound_cursorvar [ [ NO ] SCROLL ] FOR query;
```

```sql
OPEN curs1 FOR SELECT * FROM foo WHERE key = mykey;

OPEN curs2;
OPEN curs3(42);
OPEN curs3(key := 42);
```

```sql
DECLARE
key integer;
curs4 CURSOR FOR SELECT * FROM tenk1 WHERE unique1 = key;
BEGIN
key := 42;
OPEN curs4;
```

Práce s kurzorem:

Next row:

```
FETCH [ direction { FROM | IN } ] cursor INTO target;
```

direction: NEXT, PRIOR, FIRST, LAST, ABSOLUTE
count, RELATIVE count, FORWARD, or BACKWARD.

```sql
FETCH curs1 INTO rowvar;
FETCH curs2 INTO foo, bar, baz;
FETCH LAST FROM curs3 INTO x, y;
FETCH RELATIVE -2 FROM curs4 INTO x;
```

Nastavení na řádek:

```
MOVE [ direction { FROM | IN } ] cursor;
```

```sql
MOVE curs1;
MOVE LAST FROM curs3;
MOVE RELATIVE -2 FROM curs4;
MOVE FORWARD 2 FROM curs4;
```

UPDATE, DELETE

```
UPDATE table SET ... WHERE CURRENT OF cursor;
DELETE FROM table WHERE CURRENT OF cursor;
```

```sql
UPDATE foo SET dataval = myval WHERE CURRENT OF curs1;
```

Zavřít:

```sql
CLOSE curs1;
```

(automaticky na konci transakce)

Kurzory z funkce:

```sql
CREATE TABLE test (col text);
INSERT INTO test VALUES ('123');
CREATE FUNCTION reffunc(refcursor) RETURNS refcursor AS $$
BEGIN
OPEN $1 FOR SELECT col FROM test;
RETURN $1;
END;
$$ LANGUAGE plpgsql;
BEGIN;
SELECT reffunc('funccursor');
FETCH ALL IN funccursor;
COMMIT;
```

```sql
CREATE FUNCTION reffunc2() RETURNS refcursor AS '
DECLARE
ref refcursor;
BEGIN
OPEN ref FOR SELECT col FROM test;
RETURN ref;
END;
' LANGUAGE plpgsql;
-- need to be in a transaction to use cursors.
BEGIN;
SELECT reffunc2();
FETCH ALL IN "<unnamed cursor 1>";
COMMIT;
```

Procházení kurzorem

```
[ <<label>> ]
FOR recordvar IN bound_cursorvar [ ( [ argument_name
:= ] argument_value [, ...] ) ] LOOP
statements
END LOOP [ label ];
```

---

---

---

Chyby a zprávy:

```
RAISE [ level ] 'format' [, expression [, ... ]] [ USING option
= expression [, ... ] ];
RAISE [ level ] condition_name [ USING option = expression
[, ... ] ];
RAISE [ level ] SQLSTATE 'sqlstate' [ USING option = expression
[, ... ] ];
RAISE [ level ] USING option = expression [, ... ];
RAISE ;
```

level: DEBUG, LOG, INFO, NOTICE,
WARNING, and EXCEPTION, default EXCEPTION: aborts transaction

````sql
RAISE EXCEPTION 'Nonexistent ID -- > % ', user_id

USING HINT = 'Please check your user ID';```

```sql
RAISE division_by_zero;
RAISE SQLSTATE '22012';
```

```sql
ASSERT condition [ , message ];
```
-->
