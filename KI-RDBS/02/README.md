# 02 – Joins, agregace, pohledy.

> spusťte [docker kontejner](../Docker/docker-compose.yml) s PostgreSQL a CloudBeaver \
> vytvořte tabulky: proveďte [SQL z minulého týdne](./weather.sql)

## Hierarchie objektů v PostgreSQL:

- _Databáze_
  - `postgres` (default)
    - _Schémata_
      - `public` (default)
        - _Tabulky_
          - `cities`
          - `weather`

> vypište databáze ze systémového katalogu

```sql
SELECT * FROM pg_database;
SELECT datname FROM pg_database;
```

> vypište tabulky ze systémového katalogu

```sql
SELECT * FROM pg_catalog.pg_tables;
SELECT schemaname as schema, tablename as table FROM pg_catalog.pg_tables;
```

### Spojování tabulek – JOIN

Jednotlivé tabulky, kartézský součin.

```sql
SELECT * FROM cities;
SELECT * FROM weather;
SELECT * FROM cities, weather;
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

- count, min, max, avg, sum

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
