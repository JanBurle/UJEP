# 07 – Uložené funkce a procedury

PostgreSQL intenzivně využívá systémový katalog pro rozšiřování SQL, a to i za běhu:

- složené (řádkové) typy,
- domény nad typy
- uživatelské (uložené) funkce a procedury, ...

Uživatelské funkce a procedury uložené a prováděné na straně serveru rozšiřují funkčnost DBS a řídí přístup k databázím.

Využití funkcí:

- v různých sekcích SQL příkazů, typicky v SELECT
- jako uživatelské agregační funkce a operátory
- jako producenty vypočtených tabulek, tj. ve funkci read only pohledů.

Využití procedur:

- Jako skripty pro komplexnější vkládání hodnot.
- Jako dávkové soubory pro údržbu databáze.
- Jako obslužné rutiny triggerů (aktivovány při vkládání, změně a výmazu tabulek)

Funkce a procedury je možné vytvářet pomocí několika programovacích jazyků:

- standardní SQL: bezpečné a rychlé, ale s omezenými možnostmi
- procedurální rozšíření SQL (PL/pgSQL): integrované, ale nezvyklá syntaxe
- procedurální skriptovací jazyky (PL/Python, PL/Tcl, PL/Perl)
- kompilované (C ap., super rychlé), statically linked
- kompilované, dynamicky loadable

Rozdíly mezi funkcemi a procedurami. Procedury:

- nevrací funkční hodnotu, nelze použít např. v SELECT
- izolované volání (CALL)
- mohou volat COMMIT, ROLLBACK
- nedefinují strictness

## Definice uložené funkce

SQL funkce: language SQL

```
create function <name>(<params>) returns <type> as $$
  <function body>
$$ language <language>;
```

Tělo funkce je v řetězci, kvůli podpoře více programovacích jazyků. Dvojznak $$ je nejčastěji používaný omezovač řetězce. Přesto se tělo parsuje.

```sql
create table emp (
  salary decimal
);

create function clean_emp() returns void as $$
  delete from emp where salary < 0;
$$ language sql;

select clean_emp();
call clean_emp(); -- ne
```

```sql
drop function clean_emp;
create or replace procedure clean_emp() as $$
  delete from emp where salary < 0;
$$ language sql;

select clean_emp(); -- ne
call clean_emp();
```

Parametry se předávají hodnotou:

```sql
create function add(x integer, y integer) returns integer as $$
  select x + y;
$$ language sql;

select add(1,2);
```

I funkce mohou mít vedlejší efekty:

```sql
create table bank (
  account_no integer,
  balance money
);

insert into bank values (42, 10_000);

create function debit_account(account_no integer, debit money)
returns money as $$
  update bank
    set balance = balance - debit
  where account_no = debit_account.account_no; -- qualified parameter name
  select balance from bank where account_no = debit_account.account_no;
$$ language sql

select debit_account(42, 1.90::money);
```

Funkce mohou pracovat se složenými typy:

```sql
create type complex as (r real, i real);

create function cmul(x complex, y complex) returns complex as $$
  select x.r * y.r - x.i * y.i, x.r * y.i + x.i * y.r;
$$ language sql;

select cmul((3,2), (1,7));
```

Lze zavést uživatelské operátory:

```sql
create operator *
  (leftarg = complex, rightarg = complex,
   function = cmul,
   commutator = *
  );

create table test_complex (
  a complex,
  b complex
);

insert into test_complex values((3,2), (1,7));
select * from test_complex;

select (a * b) as c from test_complex;
select (a + b) as c from test_complex; -- ne
```

Procedury a funkcce mohou dále mít:

- výstupní parametry
- proměnné (vaiadic) množství parametrů
- implicitní (default) hodnoty parametrů.

Funkce mohou vracet tabulky:

```sql
select * from city;

create function cities()
returns table(id char(2), name text) AS $$
  select id, name from city
$$ language sql;

-- funkce lze přetěžovat:
create function cities(in_id text)
returns table(id char(2), name text) AS $$
  select id, name from city where id like in_id
$$ language sql;

select * from city;
select * from cities();
select * from cities() where id like 'b%';
select * from cities('b%');
```

U funkcí lze specifikovat volatilitu:

- VOLATILE smí dělat cokoli (vedlejší účinky), následná volání mohou vracet různé výsledky, nelze optimizovat)
- STABLE nemění databázi a v _jednom příkazu_ pro stejné vstupní hodnoty vrátí stejný výsledek
- IMMUTABLE nemění databázi a _vždy_ pro stejné vstupní hodnoty vrátí stejný výsledek, lze ji rozbalit (un/fold into) do příkazu
