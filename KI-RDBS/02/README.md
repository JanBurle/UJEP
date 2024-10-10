# 02 – Joins, agregace, pohledy.

- _[Postgres dokumentace Ch. 3](https://www.postgresql.org/docs/17/tutorial-advanced.html)_
- _[Literatura](../README.md)_

Příprava:

- spusťte docker kontejner (minimální [docker-compose](../Docker/docker-compose.yml)) s databázovým systémem (serverem) PostgresSQL a s webovou aplikací pro správu dat CloudBeaver
- vytvořte tabulky: proveďte [SQL z minulého týdne](./weather.sql)

```sql
CREATE TABLE cities (
  name varchar(80),
  location point
);

CREATE TABLE weather (
  city varchar(80),
  temp_lo int,  -- low temperature
  temp_hi int,  -- high temperature
  prcp real,    -- precipitation
  date date
);

INSERT INTO cities VALUES ('San Francisco',  '(37.78, -122.42)');
INSERT INTO cities VALUES ('Ústí nad Labem', '(50.66, 14.04)'),
                          ('Louny',          '(50.36, 13.79)'),
                          ('Bílina',         '(50.54, 13.78)');

INSERT INTO weather VALUES ('San Francisco', 19, 29, 0.25, '2014-10-02');
INSERT INTO weather (city, temp_lo, temp_hi, prcp, date)
       VALUES ('Ústí nad Labem', 7, 16, 28, '2014-10-02');

INSERT INTO weather (date, city, temp_hi, temp_lo) VALUES
  ('2014-10-03', 'San Francisco', 17, 26), -- chyba
  ('2014-10-02', 'Louny', 18, 12),
  ('2014-10-02', 'Dresden', 12, 8);
```

_Zvyk: klíčová slova v SQL velkými písmeny. (Od příště ne, buďme moderní, máme syntax highlighting.)_

## Hierarchie objektů v PostgreSQL:

- _Databáze_
  - `postgres` (default)
    - _Schémata_
      - `public` (default)
        - _Tabulky_
          - `cities`
          - `weather`

Vypište databáze ze systémového katalogu:[^1]
[^1]: eat you own dog food

```sql
SELECT * FROM pg_database;
SELECT datname FROM pg_database;
```

Vypište tabulky ze systémového katalogu:

```sql
SELECT * FROM pg_catalog.pg_tables;
SELECT schemaname as schema, tablename as table FROM pg_catalog.pg_tables;
```

### Spojování tabulek – JOIN

Jednotlivé tabulky (data rozložena podle NF): jejich kartézský součin.

```sql
SELECT * FROM cities;
SELECT * FROM weather;
SELECT * FROM cities, weather;
SELECT * FROM cities CROSS JOIN weather; -- stejné
```

Inner join – původní verze SQL:

```sql
SELECT * FROM cities, weather WHERE name = city;
```

Vyjmenovaná pole:

```sql
-- SELECT city, date, temp_lo, temp_hi FROM cities, weather;
SELECT city, date, temp_lo, temp_hi FROM cities, weather WHERE name = city;
```

Inner join – moderní SQL:

```sql
SELECT * FROM cities INNER JOIN weather ON name = city;
```

Stejné:

```sql
SELECT * FROM cities JOIN weather ON name = city;
```

Vyjmenovaná pole:

```sql
SELECT city, location, date, temp_lo, temp_hi FROM cities JOIN weather ON name = city;
```

Kvalifikovaná jména polí:

```sql
SELECT weather.city, cities.location, weather.date, weather.temp_lo, weather.temp_hi FROM cities JOIN weather ON name = city;
```

Aliasy (přezdívky):

```sql
SELECT w.city, c.location, w.date, w.temp_lo, w.temp_hi FROM cities c JOIN weather w ON name = city;
```

### Levé, pravé vnější spojení: OUTER JOIN

```sql
-- SELECT * FROM cities, weather;
-- SELECT * FROM cities JOIN weather ON name = city;
SELECT * FROM cities LEFT OUTER JOIN weather ON name = city;
SELECT * FROM cities RIGHT OUTER JOIN weather ON name = city;
```

Bez OUTER, stejné:

```sql
-- SELECT * FROM cities, weather;
-- SELECT * FROM cities JOIN weather ON name = city;
SELECT * FROM cities LEFT JOIN weather ON name = city;
SELECT * FROM cities RIGHT JOIN weather ON name = city;
```

### Self JOIN

```sql
SELECT w1.city, w1.temp_lo AS low, w1.temp_hi AS high, w2.city, w2.temp_lo AS low, w2.temp_hi AS high FROM weather w1 JOIN weather w2 ON w1.temp_lo < w2.temp_lo AND w1.temp_hi > w2.temp_hi;
```

Lépe formátované pro čitelnost:

```sql
SELECT w1.city, w1.temp_lo AS low, w1.temp_hi AS high,
       w2.city, w2.temp_lo AS low, w2.temp_hi AS high
  FROM weather w1 JOIN weather w2
  ON w1.temp_lo < w2.temp_lo AND w2.temp_hi < w1.temp_hi;
```

### Agregační funkce

> count, min, max, avg, sum, [...](https://www.postgresql.org/docs/current/functions-aggregate.html)

Počet záznamů:

```sql
SELECT count(*) FROM weather;
SELECT count(city) FROM weather;
SELECT count(distinct city) FROM weather;
```

Kombinace agregačních funkcí a výpočtu:

```sql
select count(*), min(temp_lo), max(temp_hi), avg(temp_hi-temp_lo), sum(prcp) from weather;
```

Agregační funkce nelze použít pro selekci:

```sql
SELECT city FROM weather WHERE temp_lo = max(temp_lo); -- špatně
```

Toto lze provést vnořeným SELECT:

```sql
-- SELECT city, temp_lo FROM weather;
-- SELECT max(temp_lo) FROM weather;
SELECT city FROM weather WHERE temp_lo = (SELECT max(temp_lo) FROM weather);
```

### Shlukování řádků – GROUP BY

Použitá pole v SELECT musí být buď agregovaná nebo uvedená v GROUP BY.

```sql
SELECT city, temp_lo FROM weather;
SELECT count(*) FROM weather;
SELECT max(temp_lo) FROM weather;
SELECT count(*), max(temp_lo) FROM weather;
SELECT city, count(*), max(temp_lo) FROM weather; -- chyba
SELECT city, count(*), max(temp_lo) FROM weather GROUP BY city;
```

S filtrem skupin a selekcí řádků:

```sql
SELECT city, count(*), max(temp_lo) FROM weather GROUP BY city;
SELECT city, count(*), max(temp_lo) FROM weather GROUP BY city HAVING max(temp_hi) < 20;
SELECT city, count(*), max(temp_lo) FROM weather WHERE city LIKE '%s%' GROUP BY city;
SELECT city, count(*), max(temp_lo) FROM weather WHERE city LIKE '%s%' GROUP BY city HAVING max(temp_hi) < 20;
```

Filtrování pro výpočet agregovaných hodnot:

```sql
SELECT city, temp_lo FROM weather;
SELECT city, count(*), max(temp_lo) FROM weather GROUP BY city;
SELECT city, count(*) FILTER (WHERE temp_lo < 20), max(temp_lo) FROM weather GROUP BY city;
```

### Views – pohledy

Virtuální tabulka:

```sql
-- SELECT city, location, date, temp_lo, temp_hi FROM cities JOIN weather ON name = city;
CREATE VIEW city_weather AS
  SELECT city, location, date, temp_lo, temp_hi FROM cities JOIN weather ON name = city;
```

Použití:

```sql
SELECT * FROM city_weather;
SELECT city, date FROM city_weather;
SELECT * FROM city_weather WHERE temp_lo > 10;
SELECT * FROM city_weather WHERE temp_lo > 10 GROUP BY city; -- chyba
SELECT city, avg(temp_lo) FROM city_weather WHERE temp_lo > 10 GROUP BY city;
```

## Referenční integrita a integrita dat

Databáze se musí ubránit špatným datům!

```sql
DROP TABLE IF EXISTS city;

CREATE TABLE city (
  id char(2) PRIMARY KEY,
  name varchar(80) NOT NULL
);

CREATE UNIQUE INDEX idx_city_name on city(name);

DROP TABLE IF EXISTS city;

CREATE TABLE city (
   id char(2) PRIMARY KEY,
  name varchar(80) UNIQUE NOT NULL
);

INSERT INTO city (id, name) VALUES ('sf', 'San Francisco');
INSERT INTO city (id, name) VALUES ('sf', 'San Francisco');   -- chyba
INSERT INTO city (id) VALUES ('ul');                          -- chyba
INSERT INTO city (name) VALUES ('Ústí nad Labem');            -- chyba
INSERT INTO city (id, name) VALUES ('ull', 'Ústí nad Labem'); -- chyba
INSERT INTO city (id, name) VALUES ('ul', 'Ústí nad Labem');
INSERT INTO city (id, name) VALUES ('lo', 'Louny');
INSERT INTO city (id, name) VALUES ('bn', 'Bílina');
INSERT INTO city (id, name) VALUES ('bi', 'Bílina');          -- chyba

CREATE TABLE weather (
  city_id char(2) REFERENCES city(id),
  temp_lo int NOT NULL,
  temp_hi int NOT NULL,
  date date NOT NULL DEFAULT CURRENT_DATE,
  CONSTRAINT check_temp CHECK(temp_lo <= temp_hi),
  UNIQUE (city_id, date)
);

INSERT INTO weather
  VALUES ('sf', 19, 29, '2014-10-02'),
         ('ul',  7, 16, '2014-10-02'),
         ('sf', 26, 17, '2014-10-03'), -- chyba
         ('lo', 12, 18, '2014-10-02'),
         ('dr',  8, 12, '2014-10-02'); -- chyba 'Dresden'

INSERT INTO weather VALUES ('ul',  14, 21);
INSERT INTO weather VALUES ('ul',  14, 21); -- chyba
```

A pak:

```sql
SELECT * FROM city;
SELECT * FROM weather;
SELECT * FROM city, weather;

SELECT * FROM city, weather WHERE id = city_id;

SELECT * FROM city JOIN weather ON id = city_id;

SELECT * FROM city LEFT JOIN weather ON id = city_id;
SELECT * FROM city RIGHT JOIN weather ON id = city_id; -- ha!
```

ON DELETE RESTRICT:

```sql
DELETE FROM city; -- chyba
```

ON DELETE CASCADE:

```sql
DROP TABLE IF EXISTS weather;

CREATE TABLE weather (
  city_id char(2) REFERENCES city(id) ON DELETE CASCADE,
  temp_lo int NOT NULL,
  temp_hi int NOT NULL,
  date date NOT NULL DEFAULT CURRENT_DATE,
  CONSTRAINT check_temp CHECK(temp_lo <= temp_hi),
  UNIQUE (city_id, date)
);

-- INSERT ...
```

```sql
DELETE FROM city; -- POOF!
```
