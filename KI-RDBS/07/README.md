# 07 – Uložené funkce a procedury

PostgreSQL intenzivně využívá systémový katalog pro rozšiřování SQL, a to i za běhu databázového systému:

- složené (řádkové) typy,
- domény nad typy
- uživatelské (uložené) funkce a procedury
- další ...

Uživatelské funkce a procedury uložené a prováděné na straně serveru rozšiřují funkčnost DBS a lze je použít pro řízení přístupu k databázím.

Využití funkcí:

- jako funkce v různých sekcích SQL příkazů, typicky v SELECT
- jako uživatelské agregační funkce
- pro implementaci uživatelských operátorů
- jako producenty vypočtených tabulek, tj. ve funkci read only pohledů.

Využití procedur:

- jako skripty pro komplexnější vkládání hodnot
- jako dávkové soubory pro údržbu databáze
- Jako obslužné rutiny triggerů (aktivovány při vkládání, změně a výmazu tabulek)

Funkce a procedury je možné vytvářet pomocí několika programovacích jazyků:

- standardní SQL: bezpečné a rychlé, ale s omezenými možnostmi
- procedurální rozšíření SQL (PL/pgSQL): integrované, ale nezvyklá syntaxe
- procedurální skriptovací jazyky (PL/Python, PL/Tcl, PL/Perl)
- kompilované (C ap., super rychlé), statically linked
- kompilované, dynamicky loadable

Rozdíly mezi funkcemi a procedurami. Procedury:

- nevrací funkční hodnotu, proto je nelze použít např. v SELECT
- volány příkazem CALL
- mohou pracovat s transkcemi: COMMIT, ROLLBACK
- nedefinují strictness/volatility

## Definice uložené funkce

SQL funkce

```
create function <name>(<params>) returns <type> as $$
  <function body>
$$ language <language>;
```

nebo:

```
create function <name>(<params>) returns <type> language <language> as $$
  <function body>
$$;
```

Tělo funkce je v řetězci, kvůli podpoře více programovacích jazyků. Přesto se tělo parsuje. Dvojznak $$ je nejčastěji používaný omezovač řetězce.

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

Příklad funkce, která vypočítá vzdálenost dvou 2D bodů, SQL:

```sql
create or replace function distance(x1 real, y1 real, x2 real, y2 real)
returns real as $$
  select sqrt((x2-x1) * (x2-x1) + (y2-y1) * (y2-y1));
$$ language sql;

select distance(1,2,3,4);
select distance(0,3,4,0);
```

PLPGSQL:

```sql
create or replace function distance(x1 real, y1 real, x2 real, y2 real)
returns real as $$
  declare
    dx real = x2-x1;
    dy real = y2-y1;
begin
  return sqrt(dx*dx + dy*dy);
end; $$ language plpgsql;

select distance(1,2,3,4);
select distance(0,3,4,0);
```

V tabulce 2D bodů nalezněte dva nejbližší body:

```sql
-- tabulka
create table points (
  id serial primary key,
  x real not null,
  y real not null
);

-- náhodná souřadnice
create function rnd(lo real, hi real)
returns real as $$
  select lo + random()*(hi - lo)
end; $$ language sql;

-- test
select rnd(-100,+100);

-- naplnit tabulku
do $$
declare
  i integer;
begin
  for i in 0..99 loop
    insert into points (x,y) values (rnd(-100,+100), rnd(-100,+100));
  end loop;
end $$;

-- kontrola tabulky
select * from points;
select count(*) from points;

-- kombinace bodů každý s každým
select * from points a cross join points b;
-- vyloučit sám sebe a duplikáty
select * from points a cross join points b
  where a.id < b.id;
-- kontrola počtu
select count(*) from points a cross join points b
  where a.id < b.id;

-- výpočet vzdáleností
select a.id, b.id, distance(a.x,a.y,b.x,b.y) as d
  from points a cross join points b
  where a.id < b.id;

-- jako pohled
create view distances as
select a.id as a_id, b.id as b_id, distance(a.x,a.y,b.x,b.y) as dist
  from points a cross join points b
  where a.id < b.id;

-- výpočet
select * from distances order by dist limit 1;
```

Funkce _mohou_ mít vedlejší účinky (side-effects):

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

Funkce

Procedury a funkcce mohou dále mít:

- výstupní parametry
- proměnné (variadic) množství parametrů
- implicitní (default) hodnoty parametrů

Funkce mohou množiny hodnot:

```sql
create function square_series(max int)
returns setof int as $$
 select i * i from generate_series(1, max) as i
$$ language sql;

select square_series(8);
```

Funkce mohou vracet tabulky:

```sql
select * from city;

create function cities()
returns table(id char(2), name text) AS $$
  select id, name from city
$$ language sql;
```

Funkce lze přetěžovat:

```sql

create function cities(in_id text)
returns table(id char(2), name text) as $$
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

```sql
create function cubic_series(max int)
returns setof int immutable as $$
  select i*i*i from generate_series(1, max) as i
$$ language sql;

select cubic_series(8);
```

Použití funkce generující množinu hodnot. Rodokmen (hierarchie):

```sql
create table family_tree (
  id serial primary key,
  name text not null,
  mother integer references family_tree(id) default null,
  father integer references family_tree(id) default null
);

create index idx_mother on family_tree(mother);
create index idx_father on family_tree(father);
```

Naplnit daty:

```sql
-- adam and eve
insert into family_tree (name) values ('Adam'); -- 1
insert into family_tree (name) values ('Eve');  -- 2

-- their children
insert into family_tree (name, mother, father) values ('Cain', 2, 1); -- 3
insert into family_tree (name, mother, father) values ('Abel', 2, 1); -- 4
insert into family_tree (name, mother, father) values ('Seth', 2, 1); -- 5

-- Cain's descendats
insert into family_tree (name, mother, father) values ('Enoch', null, 3); -- 6
insert into family_tree (name, mother, father) values ('Irad', null, 6);  -- 7

-- Seth's descendants
insert into family_tree (name, mother, father) values ('Cainan', null, 5);   -- 8
insert into family_tree (name, mother, father) values ('Mahalalel', null, 8); -- 9
```

Funkce:

```sql
create or replace function children_of(text) returns setof text as $$
 select child.name from family_tree child
  join family_tree parent on parent.id=child.mother or parent.id=child.father
  where parent.name = $1
$$ language sql stable;

select children_of('Adam');
select name, child from family_tree, children_of(name) as child;
```

Index???

```sql
explain select name, child from family_tree, children_of(name) as child;
create index idx_name on family_tree(name);
explain select name, child from family_tree, children_of(name) as child;
drop index idx_name;
explain select name, child from family_tree, children_of(name) as child; -- what?
```
