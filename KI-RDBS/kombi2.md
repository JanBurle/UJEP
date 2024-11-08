# 2. Část

- Pohledy
- Indexy + optimalizace dotazů
- Role a uživatelé
- Funkce a procedury
- Kurzory
- Chyby, výjimky a jejich obsluha
- Triggery
- Zamykání tabulek

### Ukázková data - počasí:

Tabulky:

```sql
drop table if exists weather;
drop table if exists city;

create table city (
  id char(2) primary key,
  name varchar(80) not null
);

create table weather (
  city_id char(2) references city(id),
  temp_lo int not null,
  temp_hi int not null,
  date date not null default current_date,
  primary key (city_id, date),
  constraint check_temp check(temp_lo <= temp_hi)
);

create index idx_date on weather(date);
```

Naplnit daty:

```sql
do $$
declare
  id char(2); id1 integer; id2 integer; name varchar(80);
  temp_lo integer; temp_hi integer; weather_date date; days integer;
begin
  for id1 in ascii('a')..ascii('z') loop
    for id2 in ascii('a')..ascii('z') loop
      id := chr(id1) || chr(id2);
      name := 'City ' || upper(id);
      insert into city (id, name) values (id, name);

      for days in 0 .. 30 loop
        temp_lo := (random() * 30)::int;
        temp_hi := temp_lo + (random() * 10)::int;
        weather_date := current_date - days;
        insert into weather (city_id, temp_lo, temp_hi, date)
          values (id, temp_lo, temp_hi, weather_date);
      end loop;

    end loop;
  end loop;
end $$;
```

## Pohledy (views)

Dotazy vrací vypočtené tabulky:

```sql
select * from city;
select * from weather;

select city_id, date, temp_hi-temp_lo from weather;

select name, date, temp_hi-temp_lo from weather join city on id=city_id;

select c.name, w.date, w.temp_hi-w.temp_lo from weather w join city c on c.id=w.city_id;
```

Pohledy jsou "vypočtené tabulky":

```sql
create view city_weather as
  select c.name, w.date, w.temp_hi-w.temp_lo from weather w join city c on c.id=w.city_id;

select * from city_weather;

drop view city_weather;

create view city_weather as
  select c.name, w.date, w.temp_hi-w.temp_lo as d_temp from weather w join city c on c.id=w.city_id;

select * from city_weather where d_temp<4 and name like '%Z';
```

Modifikovatelné (updatable) pohledy, jean za určitých (striktních) podmínek (např. jen nad jednou tabulkou):

```sql
create view city_updatable_weather as
  select date, temp_lo, temp_hi from weather where city_id='up';
select * from city_up_weather;

update city_updatable_weather set temp_hi=30 where date='2024-10-08';
```

## Indexy + optimalizace dotazů

[Indexové soubory a analýza dotazů](./04/README.md)

## Role a uživatelé

Superuser `dbuser` definovaný v [docker skriptu](./Docker/docker-compose.yml).

Obyčejný uživatel:

```sql
create user joe password 'joepwd';
```

Otevřeme databázové spojení pro `joe` a:

```sql
-- joe
select * from city; -- doh
```

Jako superuser dáme nebo odebereme `joe` oprávnění:

```sql
-- dbuser
grant select on city to joe;
grant select,update on city to joe;
revoke select on city from joe;
revoke all on city from joe;
```

Nebo vytvoříme roli (skupinu) s oprávněními, a `joe` dostane oprávnění skupiny:

```sql
create role reader;
grant select on city to reader;

grant reader to joe;
revoke reader from joe;
```

## Funkce a procedury

[Uložené funkce a procedury](./04/README.md)

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
  city_cursor cursor for select id, name from city;
  city_record record;
  cnt integer;
begin
  cnt = 0;

  open city_cursor; -- where??
  loop
    fetch next from city_cursor into city_record;
    exit when not found;
    if city_record.name like like_name then
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

Další ukázková funkce s kurzorem:

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
end; $$ language plpgsql;

select avg_temp_lo();
select avg_temp_lo('%');
select avg_temp_lo('%z');
select avg_temp_lo('%Z'); -- error
-- add exception handler
-- add raise exception
```

## Triggery

[Triggery](./10/README.md)

## Zamykání tabulek

Transakce:

- zajištění integrity dat při chybách
- concurrency control: synchronizace současného přístupu k tabulkám

Postgres: MVCC - Multiversion Concurrency Control

Izolace transakcí (transakčních snímků, snapshots) - každá vidí data, jak byla před chvilkou, v posledním konzistentním stavu.

Izolace transakcí podle SQL standardu:

- READ UNCOMMITED (Postgres: READ COMMITED)
- READ COMMITED (data ve stavu než transakce začala, default)
- REPEATABLE READ (data před prvním příkazem)
- SERIALIZABLE (jakoby transakce byly porováděny jedna za druhou)

Pokud není potřeba plná izolace transakcí, lze i explicitně zamykat tabulky. Zamykání má účinek jen v transakcích. (Není sooučástí standardníhon SQL.)

Neodemyká se, zámky platí až do konce transakce.

```
LOCK [ TABLE ] [ ONLY ] name [ * ] [, ...] [ IN lockmode MODE ] [ NOWAIT ]
```

```sql
LOCK TABLE name IN SHARE MODE;
```

## Deadlock

Aby nenastal deadlock:

- všechny transakce by měly zamykat sdílené objekty (tabulky) ve stejném pořadí
- pokud se jeden objekt zamyká vícero zámky, nejsilnější zámek musí být první

#### Poznámka

Může nastat implicitní ROLLBACK.

---

CTE 06, ORM: později
