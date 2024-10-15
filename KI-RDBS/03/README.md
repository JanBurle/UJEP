# 03 – Analytické funkce (windows functions)

## Referenční integrita a integrita dat

Databáze se musí umět ubránit špatným datům!

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

subqueries 7.2.1.3.

city

CREATE TABLE city (
id char(2) primary key,
name varchar(80)
);

INSERT INTO weather VALUES ('Berkeley', 45, 53, 0.0, '1994-11-28');
ERROR: insert or update on table "weather" violates foreign key
constraint "weather_city_fkey"
DETAIL: Key (city)=(Berkeley) is not present in table "cities".

````


transactions
UPDATE accounts SET balance = balance - 100.00
WHERE name = 'Alice';
UPDATE branches SET balance = balance - 100.00
WHERE name = (SELECT branch_name FROM accounts WHERE name =
'Alice');
UPDATE accounts SET balance = balance + 100.00
WHERE name = 'Bob';
UPDATE branches SET balance = balance + 100.00
WHERE name = (SELECT branch_name FROM accounts WHERE name =
'Bob');

postgres
BEGIN;
UPDATE accounts SET balance = balance - 100.00
WHERE name = 'Alice';
-- etc etc
COMMIT;

BEGIN;
UPDATE accounts SET balance = balance - 100.00
WHERE name = 'Alice';
SAVEPOINT my_savepoint;
19
Advanced Features
UPDATE accounts SET balance = balance + 100.00
WHERE name = 'Bob';
-- oops ... forget that and use Wally's account
ROLLBACK TO my_savepoint;
UPDATE accounts SET balance = balance + 100.00
WHERE name = 'Wally';
COMMIT;

- JF aggregate etc ...

---

self-reference
CREATE TABLE tree (
node_id integer PRIMARY KEY,
parent_id integer REFERENCES tree,
name text,
...
);

2 ============================================================================

window functions 3.5

```


install: docker

$ createdb [mydb]
$ dropdb mydb
$ psql mydb

postgres source
cd .../src/tutorial
make
$ psql -s mydb
mydb=> \i basics.sql

--- ppokr




- syntax
- postgres types

Syntax
kws, ids
case insensitive, quoted ids case sensitive
convention: kw uppercase "" all chars except \0
constants 'srin''gs' c-like escapes
$tag$.....$tag$
B'1001'
X'1FF'

3.5 4.
.001
5e2
1.925e-3

0xhexdigits
0ooctdigits
0bbindigits

integer/bigint/numeric
1_500_000_000
0b10001000_00000000
0o_1_755
0xFFFF_FFFF
1.618_034

REAL '1.23' -- string style
1.23::REAL -- PostgreSQL (historical) style

type 'string'
'string'::type
CAST ( 'string' AS type )

comments
-- xxxx
/_ ... _/

https://www.postgresqltutorial.com/postgresql-administration/postgresql-create-database/

CREATE DATABASE database_name
https://www.postgresqltutorial.com/postgresql-administration/postgresql-create-database/

https://www.postgresqltutorial.com/postgresql-administration/postgresql-schema/
```
````
