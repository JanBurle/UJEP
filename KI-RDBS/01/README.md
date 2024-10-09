# 01 – PostgreSQL

[PostgreSQL](https://en.wikipedia.org/wiki/PostgreSQL):

- moderní databáze (databázový systém)
- open source
- cross-platform
- škálovatelná (scalable)
- vývoj: podporovaný komunitou

Jméno: PostgreSQL << POSTGRES << Ingres

## Instalace

### Databázový systém + nástroje:

- [PostgreSQL](https://www.postgresql.org/)
- [pgAdmin](https://www.pgadmin.org/)
- [DBeaver Community Edition](https://dbeaver.io/)
- [CloudBeaver Community](https://dbeaver.com/docs/cloudbeaver/)
- jiné?

### Docker:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [compose.yaml](../Docker/PostgreSQL/compose.yaml)

```bash
docker compose up # watch the log
```

- CloudBeaver – [localhost:8001](http://localhost:8001)
- pgAdmin – [localhost:8002](http://localhost:8002)

### CloudBeaver, konfigurace:

- Setup: Administrator Credentials
  - cbadmin / \<heslo\>
- Login (cbadmin)
- Find Local Database / New Connection: PostgreSQL
  - Authentication: dbuser / dbpwd
  - Host: **postgresql**
  - Test, Create

### pgAdmin, konfigurace:

- Login: admin@admin.com / admin
- Register Server:
  - General/Name: ....
  - Connection/Host name: **postgresql**
  - Username: dbuser, Password: dbpwd

### DBeaver, konfigurace:

- Database / New Database Connection / PostgreSQL
- Host: **localhost**
- Username: dbuser, Password: dbpwd
- (download driver files)

## [SQL](https://en.wikipedia.org/wiki/SQL) – Structured Query Language

- **DDL**: Data Definition (CREATE, ALTER, DROP, ...)
- **DQL**: Data Query (SELECT)
- **DML**: Data Manipulation (INSERT, UPDATE, DELETE, ...)
- **DCL**: Data Control (CREATE USER, GRANT, REVOKE)
- **TCL**: Transaction Control (BEGIN, COMMIT, ROLLBACK, ...)

### Provádění SQL

- **CloudBeaver: SQL**
- pgAdmin: Tools / Query Tool

```sql
SELECT version();
```

> 17.0

## Práce s tabulkami (DDL, DQL, DML)

_[Postgres tutoriál Ch. 2](https://www.postgresql.org/docs/17/tutorial-sql.html)_

### CREATE

```sql
CREATE TABLE cities (
  name varchar(80),
  location point
);
```

```sql
CREATE TABLE weather (
  city varchar(80),
  temp_lo int,  -- low temperature
  temp_hi int,  -- high temperature
  prcp real,    -- precipitation
  date date
);
```

Referenční integrita:

```sql
... primary key,
... references table(field),
```

Integrita dat:

```sql
... CHECK(...),
... NOT NULL,
```

### INSERT

```sql
  INSERT INTO cities VALUES ('San Francisco', '(37.78, -122.42)');
```

Více záznamů najednou:

```sql
  INSERT INTO cities VALUES ('Ústí nad Labem',  '(50.66, 14.04)'),
                            ('Louny',           '(50.36, 13.79)');
```

```sql
INSERT INTO weather VALUES ('San Francisco', 19, 29, 0.25, '2014-10-02');
```

Vyjmenovaná pole:

```sql
INSERT INTO weather (city, temp_lo, temp_hi, prcp, date) VALUES ('Ústí nad Labem', 7, 16, 28, '2014-10-02');
```

Vyjmenovaná pole, v jiném pořadí, prcp = NULL:

```sql
INSERT INTO weather (date, city, temp_hi, temp_lo) VALUES
  ('2014-10-03', 'San Francisco', 17, 26),
  ('2014-10-02', 'Louny', 18, 12),
  ('2014-10-02', 'Dresden', 12, 8);
```

### SELECT

Všechna pole:

```sql
SELECT * FROM weather;
```

Vyjmenovaná pole (projekce):

```sql
SELECT city, temp_lo, temp_hi, prcp, date FROM weather;
```

Vypočítaná pole:

```sql
-- dvojité uvozovky
SELECT city, (temp_hi+temp_lo)/2 AS "avg.temp.", date FROM weather;
```

WHERE klauzule (selekce):

```sql
SELECT * FROM weather WHERE city = 'San Francisco' AND prcp > 0.0;
```

Řazení:

```sql
SELECT * FROM weather ORDER BY city;
```

```sql
SELECT * FROM weather ORDER BY city, temp_lo;
```

Bez duplicitních záznamů:

```sql
SELECT DISTINCT city FROM weather;
```

Všechny záznamy (ALL - default):

```sql
SELECT ALL city FROM weather;
```

Kombinace:

```sql
-- jednoduché uvozovky, pattern matching
SELECT DISTINCT city FROM weather WHERE city LIKE '%r%' ORDER BY city;
```

### UPDATE

```sql
UPDATE weather SET temp_lo = -4 WHERE city = 'Louny';
```

```sql
-- temp_hi: předchozí hodnota
UPDATE weather SET temp_hi = 32, temp_lo = temp_hi - 10 WHERE city = 'Louny';
```

### DELETE

```sql
-- Updated Rows: 0
DELETE FROM weather WHERE city = 'Hayward';
```

```sql
-- všechno
DELETE FROM weather;
```

```sql
-- také všechno, efektivně
TRUNCATE weather;
```
