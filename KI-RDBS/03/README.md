# 03 –

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
