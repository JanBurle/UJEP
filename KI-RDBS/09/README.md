<!-- # 09 – Kurzory

Dotaz vrací potencielně mnoho řádků:

```sql
select * from city;
select count(*) from city;
```

Na výsledku lze otevřít kurzor (portál) a záznamy načítat postupně pomocí FETCH:

```sql

```

často vracen z funkce

```
name [ [ NO ] SCROLL ] CURSOR [ ( arguments ) ] FOR query;
```

SCROLL - i nazpět, nepoužít pro volatilní funkce, nelze použít pro UPDATE
(SCROLL předpokládá konzistenci při znovunačtení)

arguments (if)> páry jméno/datový typ (zadané při otevření kurzoru)

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
RAISE EXCEPTION 'Nonexistent ID --> %', user_id

USING HINT = 'Please check your user ID';```

```sql
RAISE division_by_zero;
RAISE SQLSTATE '22012';
```

```sql
ASSERT condition [ , message ];
```

````sql

``` -->
````
